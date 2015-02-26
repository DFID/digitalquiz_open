<?php
require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "roles.php";
$rolesHelper = new RolesHelper();
$roles = $rolesHelper->getAllRoles();
$categories = $rolesHelper->getAllCategories();
?>
<div class="wrap">
    <h1><?php _e('Roles report', 'reports')?></h1>
    <?php if(!sizeof($roles)):?>
        <p><?php _e('There are no records that match your search criteria', 'reports')?></p>
    <?php else:?>
        <form action="reports" method="post">
            <input type="hidden" value="download_roles_csv" name="action">
            <p><input type="submit" value="<?php _e('Export csv', 'reports')?>"></p>
        </form>
        <table class="widefat">
            <tr>
                <th><?php _e('Role', 'reports')?></th>
                <th><?php _e('Times taken', 'reports')?></th>
                <th><?php _e('AVG Total Score', 'reports')?></th>
                <?php foreach ($categories as $category): ?>
                    <th><?php echo $rolesHelper->formatCategoryName($category->name); ?></th>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($roles as $role): ?>
                <?php $class = ('alternate' == @$class) ? '' : 'alternate';?>
                <tr class="<?php echo $class?>">
                    <td><?php echo $role->answer; ?></td>
                    <td><?php echo $rolesHelper->getTotalQuizCount($role->answer); ?></td>
                    <td><?php echo $rolesHelper->formatOutputValue($rolesHelper->getAverageTotalScore($role->answer)); ?></td>
                    <?php foreach ($categories as $category): ?>
                        <td><?php echo $rolesHelper->formatOutputValue($rolesHelper->getCategoryScore($role->answer, $category->ID)); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>