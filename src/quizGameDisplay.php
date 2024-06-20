<?php

require_once('config.php');
ob_start();
?>


<div class="text-center d-flex flex-column justify-content-center align-items-center mt-5">
    <h2 class="text-primary text-bold"></h2>
    <div class="mt-3">
        <a class="btn btn-secondary btn-lg mr-2" href="quiz_update.php?id=<?= $id ?>">Modifier le quiz</a>
        <a class="btn btn-success btn-lg">JOUER</a>
        </div>
        
        <!-- Jeux -->
        <div class="row text-center justify-content-between">
            
            <h1 class="mt-5"></h1>
            <div class="score mt-1 align-items-center  justify-content-center">
                <p class="m-auto">Score: 0<br></p>
                </div>
                <div class="questions">
                    <h3 class="m-auto"></h3>
                    </div>
                    <div class="timmer mt-1 align-items-center justify-content-center">
                        <p id="timmer" class="m-auto">Timing: 60 sec</p>
                        </div>
                        </div>
                        
                        <div class="row d-flex flex-column text-center align-items-center  mt-5">
                            <button class="answers1 m-3 btn btn-outline-warning">
                                </button>
                                <button class="answers2 m-3 btn btn-outline-warning">
                                    </button>
                                    <button class="answers3 m-3 btn btn-outline-warning">
                                        
                                        </button>
                                        <button class="answers4 m-3 btn btn-outline-warning">
                                            
                                            </button>
                                            
                                            </div>
                                            
                                            
                                            </div>
                                            
                                            <script src="main.js" defer></script>
                                            <?php
$title = 'Quizs';
$content = ob_get_clean();
require 'layout.php';
?>


