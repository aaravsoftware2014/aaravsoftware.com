!function(e){e(document).ready(function(){"use strict";e(document).on("click",".gyan_upload_widget_image_button",function(){return jQuery.data(document.body,"prevElement",e(this).prev()),window.send_to_editor=function(e){var t=jQuery(e).attr("src"),n=jQuery.data(document.body,"prevElement");null!=n&&""!=n&&n.val(t),tb_remove()},tb_show("","media-upload.php?type=image&TB_iframe=true"),!1})})}(jQuery);