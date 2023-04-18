<div class="card card-custom card-stretch gutter-b">
  <div class="card-body">
    <div class="row mb-3">
      <div class="col">
        <h3><?= $question['question']; ?></h3>
      </div>
    </div>
    <?php foreach ($options as $option) : ?>
      <div class="d-flex justify-content-start my-2">
        <span class="label label-light-dark label-inline label-lg">
          <?= $option['dimension']; ?>
        </span>
        <label class="radio radio-outline radio-outline-2x radio-success">
          <input type="radio" name="answer" value="<?= $option['id']; ?>" />
          <span class="mx-2"></span>
          <?= $option['answer']; ?>
        </label>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<div class="card card-custom card-stretch gutter-b">
  <div class="card-body" id="feedback">
    Feedback:
  </div>
</div>