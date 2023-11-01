<?php
function displayRecommendation ($titre, $pageLink){ // le lien pageLink doit être relatif à index.php
    echo '                    <div class="col-xl-3 col-md-6 ">
                                <div class="card text-white mb-4 recommendation">
                                    <div class="card-body recoSize"> '.$titre.'</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="'.$pageLink.'">En savoir plus</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>';

}
?>
