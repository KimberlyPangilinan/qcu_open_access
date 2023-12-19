<?php
include 'function/workflow_function.php';
include 'function/email_function.php';
$aid = isset($_GET['aid']) ? $_GET['aid'] : 1;
$emc = isset($_GET['emc']) ? $_GET['emc'] : 1;

$article_data = get_article_data($aid);
$article_contributor = get_article_contributor($aid);
$email_content = get_email_content($emc);
?>

<!DOCTYPE html>
<html lang="en">
<style>
    .custom-body {
        height: 50%;
        overflow: auto;
        max-height: 400px;
        margin: 0 auto;
    }
</style>
<body>
    <!-- Include header -->
    <?php include 'template/header.php'; ?>
    <!-- Content wrapper -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="py-3 mb-4"><?php echo $article_data[0]->article_id; ?> / <?php echo $article_data[0]->title; ?></h5>

            <div class="row">
                <div class="col-xl-12">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button
                                type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true"><?php echo $email_content[0]->title; ?></button>
                            </li>
                        </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                            <div class="row">
                                <div class="col-md-12" id="dynamic-column">
                                    <h5 class="card-header">Notify Authors</h5>
                                    <p>Send an email to the authors to let them know that this submission will be sent for peer review. If possible, give the authors some indication of how long the peer review process might take and when they should expect to hear from the editors again. This email will not be sent until the decision is recorded.</p>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="defaultFormControlInput1" class="form-label">To</label>

                                            <div class="input-group">
                                                <?php
                                                $emailString = '';

                                                foreach ($article_contributor as $article_contributorval) {
                                                    if (isset($article_contributorval->email) && $article_contributorval->email !== '') {
                                                        $emailString .= $article_contributorval->email . ', ';
                                                    }
                                                }

                                                $emailString = rtrim($emailString, ', ');
                                                ?>

                                                <input type="hidden" id="hiddenEmail" name="hiddenEmail" value="<?php echo $emailString; ?>">
                                                <input type="text" class="form-control" id="author" placeholder="Author" value="Author" aria-describedby="defaultFormControlHelp" readonly/>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" id="article_id" name="article_id" value="<?php echo $article_data[0]->article_id; ?>">
                                            <input type="hidden" id="id" name="id" value="<?php print $email_content[0]->id ?>">
                                            <label for="defaultFormControlInput2" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject" placeholder="Subject" value="<?php echo $email_content[0]->subject; ?>" aria-describedby="defaultFormControlHelp" readonly/>
                                        </div>   
                                        <div class="mb-3">
                                            <input type="hidden" name="quillContentOne" id="quillContentOne">
                                            <div id="quill-emailcontent" style="height: 350px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end mt-4">
                                    <a href="../php/workflow.php?aid=<?php echo $article_data[0]->article_id; ?>&emc=1" class="btn btn-outline-danger">Cancel</a>
                                    <button type="submit" class="btn btn-primary ms-2" id="submitBtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Include footer -->
        <?php include 'template/footer.php'; ?>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
        ];

        var quill = new Quill('#quill-emailcontent', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });

        var emailContent = <?php echo json_encode($email_content[0]->content); ?>;
        var title = <?php echo json_encode($article_data[0]->title); ?>;
        var decisionText = "We have reached a decision regarding your submission to";

        if (emailContent.trim() !== '') {
            var delta = JSON.parse(emailContent);
            var titleDelta = { insert: title + '\n\n' };
            var decisionIndex = delta.ops.findIndex(op => op.insert.includes(decisionText));

            delta.ops.splice(decisionIndex + 1, 0, titleDelta);

            quill.setContents(delta); 
        } else {

            quill.setContents([{ insert: title + '\n\n' }]);
        }

        var form = document.getElementById('quillForm');
        var quillContentInputOne = document.getElementById('quillContentOne');

        var submitBtn = document.getElementById('submitBtn');
        if (submitBtn) {
            submitBtn.addEventListener('click', function () {
                sendEmail(quill);
            });
        }
    });

    function sendEmail(quillInstance) {
        $('#sloading').toggle();
        var hiddenEmail = $('#hiddenEmail').val();
        var subject = $('#subject').val();
        var article_id = $('#article_id').val();
        var id = $('#id').val();

        var title = <?php echo json_encode($article_data[0]->title); ?>;

        var deltaContent = quillInstance.getContents();
        var jsonContent = JSON.stringify(deltaContent);

        $.ajax({
            type: 'POST',
            url: '../php/function/email_function.php',
            data: {
                hiddenEmail: hiddenEmail,
                subject: subject,
                quillContentOne: jsonContent,
                article_id: article_id,
                id: id,
                title: title,
                action: 'email'
            },
            success: function (response) {
                $('#sloading').toggle();
                console.log(response);
                alert('Email sent to author successfully.');
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    </script>
</body>
</html>