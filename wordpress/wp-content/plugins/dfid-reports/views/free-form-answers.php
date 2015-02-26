<?php
require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "free-form-answers.php";
$answersHelper = new FreeFormAnswersHelper();
$questions = $answersHelper->getAllQuestions();
?>
<div class="wrap">
    <h1><?php _e('Free form answers report', 'reports')?></h1>
    <?php if(!sizeof($questions)):?>
        <p><?php _e('There are no records that match your search criteria', 'reports')?></p>
    <?php else:?>
            <?php foreach($questions as $question): ?>
            <table class="widefat">
                <thead>
                <tr>
                    <th colspan="3">
                        <?php echo stripslashes($question->question); ?> <br />
                        <?php _e('Category: '); echo $answersHelper->getCategoryNameById($question->cat_id); ?>
                    </th>
                </tr>

                <?php $class = "alternate"; ?>
                <tr class="<?php echo $class?>">
                    <th><?php _e('Answer'); ?></th>
                    <th><?php _e('ID'); ?></th>
                    <th><?php _e('Date'); ?></th>
                </tr>
                </thead>
                <?php $answers = $answersHelper->getQuestionAnswers($question->ID); ?>
                <?php if($answers): ?>
                    <?php foreach($answers as $answer): ?>
                        <?php if (trim($answer->answer)): ?>
                            <?php $class = ('alternate' == @$class) ? '' : 'alternate';?>
                            <tr class="<?php echo $class?>">
                                <td><?php echo stripslashes($answer->answer); ?></td>
                                <td><?php echo $answer->email; ?></td>
                                <td style="white-space: nowrap;"><?php echo $answersHelper->formatDate($answer->date); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <br /><br />
            <?php endforeach; ?>
    <?php endif; ?>
</div>