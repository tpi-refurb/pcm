<?php



?>
<div class="content">
    <div class="content-heading">
        <div class="container container-full">
            <h1 class="heading">Take Photo</h1>
        </div>
    </div>
    <div class="content-inner">
        <div class="container container-full">
            <div class="row row-fix">
                <div class="col-md-8">
                    <h2 class="content-sub-heading">Please click camera button.</h2>
                    <figure class="not-ready">
                        <video autoplay></video>
                    </figure>


                </div>
                <div class="col-md-3 col-md-4 content-fix">
                    <div class="content-fix-scroll">
                        <div class="content-fix-wrap">
                            <div class="content-fix-inner">
                                <h2 class="content-sub-heading">Latest Entries</h2>
                                <ul>
                                    <?php $units->print_latest_entries($global_isAdmin); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
