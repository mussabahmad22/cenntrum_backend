<?php
$pagename="dashboard";
?>
@include('layouts.header')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 xxl:col-span-9 grid grid-cols-12 gap-6">
        <!-- BEGIN: General Report -->
        <div class="col-span-12 mt-8">
            <div class="intro-y flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    General Report
                </h2>
                        <button  type="button"  class="ml-auto flex btn"><a
                            class=" flex items-center text-theme-6" href="javascript:;" data-toggle="modal"
                            data-target="#delete-modal-redeem"> <i data-feather="sidebar" class="w-4 h-4 mr-1"></i>
                            Redeem Gift Card </a>
                    </button>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" onclick="window.location.href='#'">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="aperture" class="report-box__icon text-theme-10"></i>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{$data['cards']}}</div>
                            <div class="text-base text-gray-600 mt-1">Total Gift Cards</div>
                        </div>
                    </div>
                </div>
                 <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" onclick="window.location.href='#'">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="aperture" class="report-box__icon text-theme-10"></i>
                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{$data['total']}}</div>
                            <div class="text-base text-gray-600 mt-1">Total Gift Code Active</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" onclick="window.location.href='#'">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="clipboard" class="report-box__icon text-theme-12"></i>

                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{$data['sold']}}</div>
                            <div class="text-base text-gray-600 mt-1">Total Gift Code Sold</div>
                        </div>
                    </div>
                </div>
                
                  <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y" onclick="window.location.href='#'">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <i data-feather="clipboard" class="report-box__icon text-theme-12"></i>

                            </div>
                            <div class="text-3xl font-bold leading-8 mt-6">{{$data['redeemed']}}</div>
                            <div class="text-base text-gray-600 mt-1">Total Gift Code Redeemed</div>
                        </div>
                    </div>
                </div>

            <!--    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y"-->
            <!--    onclick="window.location.href='#'">-->
            <!--    <div class="report-box zoom-in">-->
            <!--        <div class="box p-5">-->
            <!--            <div class="flex">-->
            <!--                <i data-feather="aperture" class="report-box__icon text-theme-11"></i>-->

            <!--            </div>-->
            <!--            <div class="text-3xl font-bold leading-8 mt-6">12</div>-->
            <!--            <div class="text-base text-gray-600 mt-1">Complete Appointment</div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            </div>
        </div>


    </div>

</div>
</div>
<!-- END: Content -->
</div>
<script
    src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=[" your-google-map-api"]&libraries=places"></script>
<script src="dist/js/app.js"></script>
<!-- END: JS Assets-->
</body>

@include('layouts.footer')