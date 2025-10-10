<?php $view = service('request')->getGet('view'); ?>

<?php if ($view !== 'courses'): ?>
<?php
  $enrolledCount  = isset($enrolledCourses) && is_array($enrolledCourses) ? count($enrolledCourses) : 0;
  $availableCount = isset($availableCourses) && is_array($availableCourses) ? count($availableCourses) : 0;
?>


<!-- Dashboard cards shown when not viewing 'courses' -->
<div class="row g-4">
  <!-- My Courses card -->
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body text-center">
        <h5 class="fw-semibold text-primary mb-2">My Courses</h5>
        <div class="display-6 fw-bold text-primary mb-1"><?= (int) $enrolledCount ?></div>
      <div class="text-muted small mb-2">enrolled</div>
        <div class="text-secondary small">Available: <span class="fw-semibold"><?= (int) $availableCount ?></span></div>
      </div>
    </div>
  </div>

  <!-- Assignments card -->
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body text-center">
        <h5 class="fw-semibold text-primary mb-2">Assignments</h5>
        <div class="text-muted small">due this week</div>
      </div>
    </div>
  </div>

  <!-- My Grades card -->
  <div class="col-md-4">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body text-center">
        <h5 class="fw-semibold text-primary mb-2">My Grades</h5>
        <div class="text-muted small">overall</div>
      </div>
    </div>
  </div>
</div>


<?php else: ?>
<!-- Courses view -->
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">My Courses</h3>
</div>

<div class="row g-4">
  <!-- Enrolled Courses -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-semibold text-primary mb-3">Enrolled Courses</h5>
        <?php if (empty($enrolledCourses)): ?>
          <div class="text-muted">You are not enrolled in any course yet.</div>
        <?php else: ?>
          <ul class="list-group" id="enrolled-list">
            <?php foreach ($enrolledCourses as $course): ?>
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div>
                  <div class="fw-semibold"><?= esc($course['title']) ?></div>
                  <small class="text-muted"><?= esc($course['description'] ?? '') ?></small>
                </div>
                <span class="badge bg-success">Enrolled</span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Available Courses -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm h-100">
      <div class="card-body">
        <h5 class="fw-semibold text-primary mb-3">Available Courses</h5>
        <?php if (empty($availableCourses)): ?>
          <div class="text-muted">No available courses at the moment.</div>
        <?php else: ?>
          <div class="list-group" id="available-list">
            <?php foreach ($availableCourses as $course): ?>
              <div class="list-group-item d-flex justify-content-between align-items-start" data-course-id="<?= (int) $course['id'] ?>">
                <div class="me-3">
                  <div class="fw-semibold"><?= esc($course['title']) ?></div>
                  <small class="text-muted"><?= esc($course['description'] ?? '') ?></small>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary btn-join" data-course-id="<?= (int) $course['id'] ?>">Enroll</button>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <div id="join-alert" class="mt-3" style="display:none;"></div>
      </div>
    </div>
  </div>
</div>

<script>
// Wait for jQuery to be available before binding events
(function waitForJQ(){
  if (typeof $ === 'undefined') { return setTimeout(waitForJQ, 50); }

  $(document).on('click', '.btn-join', function(e){
    e.preventDefault();
    const $btn = $(this);
    const courseId = $btn.data('course-id');

    // Debug
    console.log('Join clicked', courseId);

    $btn.prop('disabled', true).text('Joining...');

    $.ajax({
      url: '<?= base_url('course/enroll') ?>',
      type: 'POST',
      data: { course_id: courseId },
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      success: function(resp){
        if (resp && resp.success) {
          $('#join-alert').removeClass().addClass('alert alert-success').text(resp.message || 'Enrolled!').show();

          const $row = $btn.closest('[data-course-id="' + courseId + '"]');
          const title = resp.course?.title || $row.find('.fw-semibold').text();
          const desc = resp.course?.description || $row.find('small').text();

          const enrolledItem = `
            <li class="list-group-item d-flex justify-content-between align-items-start">
              <div>
                <div class="fw-semibold">${$('<div>').text(title).html()}</div>
                <small class="text-muted">${$('<div>').text(desc).html()}</small>
              </div>
              <span class="badge bg-success">Enrolled</span>
            </li>`;

          const $enrolled = $('#enrolled-list');
          if ($enrolled.length) {
            $enrolled.append(enrolledItem);
          } else {
            const $cont = $(".card:contains('Enrolled Courses') .card-body");
            $cont.find('.text-muted').remove();
            $cont.append(`<ul class="list-group" id="enrolled-list">${enrolledItem}</ul>`);
          }
          $row.slideUp(150, function(){ $(this).remove(); });
        } else {
          $('#join-alert').removeClass().addClass('alert alert-warning').text((resp && resp.message) || 'Unable to enroll').show();
          $btn.prop('disabled', false).text('Enroll');
        }
      },
      error: function(xhr){
        let msg = 'Request failed';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
        $('#join-alert').removeClass().addClass('alert alert-danger').text(msg).show();
        $btn.prop('disabled', false).text('Enroll');
      }
    });
  });
})();
</script>
<?php endif; ?>