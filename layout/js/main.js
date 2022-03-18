/*jslint browser: true*/
/*global $, jQuery, alert*/

$(document).ready(function () {
    'use strict';

    $(".bars-cont").on("click", function () {
        $(this).toggleClass("change");
        $(".menu-collapse").toggleClass("active-menu");
    });



    $(function () {

        // Viewing Uploaded Picture On Setup Admin Profile
        function livePreviewPicture(picture) {
            if (picture.files && picture.files[0]) {
                var picture_reader = new FileReader();
                picture_reader.onload = function (event) {
                    $('#uploaded').attr('src', event.target.result);
                };
                picture_reader.readAsDataURL(picture.files[0]);
            }
        }

        $('.setup-picture .picture > input').on('change', function () {
            $('#uploaded').css("display", "block");
            livePreviewPicture(this);
        });

    });
});
