<?php
require_once 'dbcon.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'send_emails':
        sendEmails();
        break;
    default:
        echo json_encode(['status' => false, 'message' => 'Invalid action']);
}

function getArticleAndContributors($articleIds) {
    $pdo = connect_to_database();

    if ($pdo && is_array($articleIds)) {
        try {
            $placeholders = implode(',', array_fill(0, count($articleIds), '?'));

            $query = "
                SELECT a.*, c.* 
                FROM article a
                LEFT JOIN contributors c ON a.article_id = c.article_id
                WHERE a.article_id IN ($placeholders)
            ";

            $stmt = $pdo->prepare($query);

            foreach ($articleIds as $index => $articleId) {
                $stmt->bindValue($index + 1, $articleId, PDO::PARAM_INT);
            }

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    return false;
}

function getArticleReviewer($articleIds) {
    $pdo = connect_to_database();

    if ($pdo && is_array($articleIds)) {
        try {
            $placeholders = implode(',', array_fill(0, count($articleIds), '?'));

            $query = "
                SELECT ra.article_id, a.author_id, a.email AS author_email
                FROM reviewer_assigned ra
                JOIN author a ON ra.author_id = a.author_id
                WHERE ra.article_id IN ($placeholders) 
            ";

            $stmt = $pdo->prepare($query);

            foreach ($articleIds as $index => $articleId) {
                $stmt->bindValue($index + 1, $articleId, PDO::PARAM_INT);
            }

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    return false;
}

function getArticleAuthor($articleIds) {
    $pdo = connect_to_database();

    if ($pdo && is_array($articleIds)) {
        try {
            $placeholders = implode(',', array_fill(0, count($articleIds), '?'));

            $query = "
                SELECT a.article_id, a.author_id, au.email AS author_email
                FROM article a
                JOIN author au ON a.author_id = au.author_id
                WHERE a.article_id IN ($placeholders) 
            ";

            $stmt = $pdo->prepare($query);

            foreach ($articleIds as $index => $articleId) {
                $stmt->bindValue($index + 1, $articleId, PDO::PARAM_INT);
            }

            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    return false;
}

function sendEmails()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkedArticles'])) {
        $checkedArticles = $_POST['checkedArticles'];
            // Your existing code for sending emails and updating status goes here
            foreach ($checkedArticles as $articleId) {
                $articleAndContributors = getArticleAndContributors([$articleId]);
                $articleAndReviewer = getArticleReviewer([$articleId]);
                $articleAndAuthor = getArticleAuthor([$articleId]);

                if (is_array($articleAndReviewer)) {
                    foreach ($articleAndReviewer as $reviewer) {
                        $reviewer_email = $reviewer['author_email'];
                        $author_id = $reviewer['author_id'];
                        // Check if the author email and author ID are not empty before executing the query
                        if (!empty($reviewer_email) && !empty($author_id)) {
                            $action_engage = "Reviewed Article Published";
                            $points = 3;
                
                            $query = "INSERT INTO user_points (user_id, email, action_engage, article_id, point_earned) VALUES (?, ?, ?, ?, ?)";
                            $result = execute_query($query, [$author_id, $reviewer_email, $action_engage, $articleId, $points]);
                        }
                    }
                }                    
                
                if (is_array($articleAndAuthor)) {
                    foreach ($articleAndAuthor as $author) {
                        $author_email = $author['author_email'];
                        $author_id = $author['author_id'];
                        
                        if (!empty($author_email) && !empty($author_id)) {
                            $action_engage = "Published an Article";
                            $points = 3;

                            $query = "INSERT INTO user_points (user_id, email, action_engage, article_id, point_earned) VALUES (?, ?, ?, ?, ?)";
        
                            $result = execute_query($query, [$author_id, $author_email, $action_engage, $articleId, $points], true);

                            $message = "Article Published";
                            $fromuser = "Admin";
                          
                            $query = "INSERT INTO logs_article (article_id, fromuser, type) VALUES (?, ?, ?)";
                            
                            $result = execute_query($query, [$articleId, $fromuser, $message], true);
                        }
                    }
                }

                if (is_array($articleAndContributors)) {
                    foreach ($articleAndContributors as $contributor) {
                        $recipient = $contributor['email'];

                        if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                            $recipient = 'qcujournal@gmail.com';
                        }

                        $articleTitle = $contributor['title'];

                        $emailContent = "Dear authors,<br><br>We have reached a decision regarding your submission to $articleTitle.<br><br>Decision: Article Published<br><br><br>Submission URL: [Your Submission URL]<br><br>";

                            $sendEmailResult = sendEmail($recipient, $articleTitle, $emailContent);

                        if ($sendEmailResult) {
                            updateStatus($articleId);
                        }
                    }
                }
            }
    

        echo json_encode(['status' => true, 'message' => 'Emails sent successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Invalid request']);
    }
}

function sendEmail($recipient, $articleTitle, $emailContent)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qcujournal@gmail.com';
        $mail->Password = 'txtprxrytyqmloth';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->addAddress($recipient);
        $mail->setFrom('qcujournal@gmail.com', 'QCU Journal');

        $subject = 'Editor Decision: ' . $articleTitle;
        $mail->Subject = $subject;

        $mail->isHTML(true);
        $mail->Body = $emailContent;

        $mail->send();

        return true;
    } catch (Exception $e) {
        // Log the error for debugging
        error_log('Error sending email: ' . $mail->ErrorInfo);
        return false;
    }
}

function updateStatus($articleId)
{
    $pdo = connect_to_database();

    if ($pdo) {
        try {
            $query = "UPDATE article SET status = 1, publication_date = NOW() WHERE article_id = :articleId";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
        }
    }
}

?>
