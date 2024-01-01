<?php
require 'dbcon.php';
require 'mail.php';
session_start();

if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN'] === true) {
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $id = $_SESSION['id'];
    $orc_idAuthor = $_SESSION['orc_id'];
    
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $privacy = $_POST['check'];
    $title = $_POST['title'];
    $abstract = $_POST['abstract'];
    $keywords = $_POST['keywords'];
    $reference = $_POST['reference'];
    $category = $_POST['journal-type'];
    $comment = $_POST['notes'];
    $volume = "Volume 1";
    $dateString = "March 2023";
    $timestamp = strtotime($dateString);
    $formattedDate = date('Y-m-d', $timestamp);
    $content = "-";
    $step = 4;
    $authorAdditionalRole = isset($_POST['authorPcontact']) ? ', Primary Contact' : '';
 


    
    
    $coAuthors = isset($_POST['contributor_type_coauthor']) ? $_POST['contributor_type_coauthor'] : array();
    $primaryContacts = isset($_POST['contributor_type_primarycontact']) ? $_POST['contributor_type_primarycontact'] : array();
    $firstNameC = $_POST['firstnameC'];
    $lastNameC = $_POST['lastnameC'];
    $publicNameC = $_POST['publicnameC'];
    $orcidsC = $_POST['orcidC'];
    $emailsC = $_POST['emailC'];


    $email = $_SESSION['email'];

    $message = "<p>You've been included as a contributor for the Journal</p><br> <label style='display: inline-block;'>Title: </label> <p style='display: inline-block;'>$title</p> <br><label style='display: inline-block;'>Abstract: </label><p style='display: inline-block;'>$abstract</p>";

    $subject = "Review Journal";
    $recipient = $email;
    send_mail($recipient, $subject, $message);





    $author_id = (isset($_SESSION['id'])) ? $_SESSION['id'] : null;
    $contributor = (isset($_SESSION['first_name'])) ? $_SESSION['first_name'] : null;

    if ($author_id === null && $contributor) {
        echo 'Can\'t find information about this user.';
        exit();
    }


    // Check if file uploads are successful
    $files = array(
        'file_name' => $_FILES['file_name']['name'],
        'file_name2' => $_FILES['file_name2']['name'],
        'file_name3' => $_FILES['file_name3']['name']
    );

    handleFileUpload($files, $contributor, $author_id, $volume, $privacy, $formattedDate, $title, $category, $abstract, $keywords, $reference, $comment, $step, $coAuthors, $primaryContacts, $firstNameC, $lastNameC, $publicNameC, $orcidsC, $emailsC, $firstName, $lastName, $orc_idAuthor, $email, $authorAdditionalRole);

    Header("Location: ex_submit.php");
    exit();
} else {
    echo 'Error: Invalid request method.';
    exit();
}

function handleFileUpload($files, $contributor, $author_id, $volume, $privacy, $formattedDate, $title, $category, $abstract, $keywords, $reference, $comment, $step, $coAuthors, $primaryContacts, $firstNameC, $lastNameC, $publicNameC, $orcidsC, $emailsC, $firstName, $lastName, $orc_idAuthor, $email, $authorAdditionalRole)
{
    global $lastInsertedArticleId;

    // Insert into article table
    $sql = "INSERT INTO article (`author`, `volume`, `privacy`, `date`, `title`, `journal_id`, `author_id`, `abstract`, `keyword`, `references`, `content`, `status`, `step`, `comment`)
            VALUES (:author, :volume, :privacy, :date, :title, :journal_id, :author_id, :abstract, :keyword, :references, :content, :status, :step, :comment)";

    $params = array(
        'author' => $contributor,
        'volume' => $volume,
        'privacy' => $privacy,
        'date' => $formattedDate,
        'title' => $title,
        'journal_id' => $category,
        'author_id' => $author_id,
        'abstract' => $abstract,
        'keyword' => $keywords,
        'references' => $reference,
        'content' => "-",
        'status' => 5,
        'step' => $step,
        'comment' => $comment
    );

    $lastInsertedArticleId = database_run($sql, $params, true);

    $uploadDirectory = "../Files/submitted-article/";

    foreach ($files as $fileKey => $fileName) {
        if (!empty($fileName)) {
            $targetFilePath = $uploadDirectory . $fileName;
            if (move_uploaded_file($_FILES[$fileKey]['tmp_name'], $targetFilePath)) {
                $fileType = ''; // Set the appropriate file type based on $fileKey
                $files_sql = "INSERT INTO article_files (article_id, author_id, file_type, file_name) VALUES (:article_id, :author_id, :file_type, :file_name)";
                $files_params = array(
                    'article_id' => $lastInsertedArticleId,
                    'author_id' => $author_id,
                    'file_type' => $fileType,
                    'file_name' => $fileName
                );

                database_run($files_sql, $files_params);
            } else {
                Header("Location: ex_submit.php");
                exit();
            }
        }
    }



    
    $sqlAuthor = "INSERT INTO contributors (article_id, contributor_type, firstname, lastname, publicname, orcid, email) 
    VALUES (:article_id, :contributor_type, :firstname, :lastname, :publicname, :orcid, :email)";

    $paramsAuthor = array(
        'article_id' => $lastInsertedArticleId,
        'contributor_type' => 'Author' . $authorAdditionalRole,
        'firstname' => $firstName,
        'lastname' => $lastName,
        'publicname' => 'Vinmarin',
        'orcid' => $orc_idAuthor,
        'email' => $email,
    );

    database_run($sqlAuthor, $paramsAuthor);



    foreach ($firstNameC as $key => $firstName) {
        $contributorType = array();
    
       
        if (isset($coAuthors[$key]) && $coAuthors[$key] == 'Co-Author') {
            $contributorType[] = 'Co-Author';
        }
    
        // Check if Primary Contact checkbox is selected for this contributor
        if (isset($primaryContacts[$key]) && $primaryContacts[$key] == 'Primary Contact') {
            $contributorType[] = 'Primary Contact';
        }
    
        // Combine roles into a comma-separated string
        $contributorTypeString = implode(' , ', $contributorType);

        $sqlCont = "INSERT INTO contributors (article_id, contributor_type, firstname, lastname, publicname, orcid, email) VALUES (:article_id, :contributor_type, :firstname, :lastname, :publicname, :orcid, :email)";    
        $paramsCont = array(
            'article_id' => $lastInsertedArticleId,  // You may replace this with the appropriate article_id
            'contributor_type' => $contributorTypeString,
            'firstname' => $firstName,
            'lastname' => $lastNameC[$key],
            'publicname' => $publicNameC[$key],
            'orcid' => $orcidsC[$key],
            'email' => $emailsC[$key],
        );

        database_run($sqlCont, $paramsCont);
    }



        $emailCont = $emailsC[$key];

        $messageCont = "<p>You've been included as a contributor for the Journal</p><br> <label style='display: inline-block;'>Title: </label> <p style='display: inline-block;'>$title</p> <br><label style='display: inline-block;'>Abstract: </label><p style='display: inline-block;'>$abstract</p>";
    
        $subjectCont = "Review Journal";
        $recipientCont = $emailCont;
        send_mail($recipientCont, $subjectCont, $messageCont);
    
    
}
?>