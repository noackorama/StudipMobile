<?
$this->setCoursePageHeader('course-activities',
                           _("Aktivitäten für %s"),
                           $course);
?>

<?= $this->render_partial('activities/_activities', compact('activities')) ?>
