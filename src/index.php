<?php
ob_start();
require_once 'config.php';

$sql = "SELECT * FROM quizs";
$result = $conn->query($sql);
$quizs = $result->fetch_all(MYSQLI_ASSOC);
?>


<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateModal">
  Update quiz
</button>

<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateModalLabel">Add quiz</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Update</button>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
  Add quiz
</button>

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Add quiz</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Push</button>
      </div>
    </div>
  </div>
</div>
<?php foreach ($quizs as $quiz) : ?>

    <div class="row g-2">

        <div class="card col-4">
            <div class="card-body">
                <h5 class="card-title text-center"><?= $quiz['name'] ?></h5>
            </div>
            <img src="https://unsplash.com/@random/collections/1000x500/<?= $quiz['name'] ?>" class="card-img-top" alt="...">

        </div>
    <div>


    <?php endforeach; ?>

    <?php


    $title = 'Quizs';
    $content = ob_get_clean();
    require 'layout.php';
    ?>