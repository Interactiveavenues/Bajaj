

function getImageDataURL(num)
{
    var video = document.getElementById('video'+num);
    $("#takephoto"+num).show();

// Get access to the camera!
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        // Not adding `{ audio: true }` since we only want video now
        navigator.mediaDevices.getUserMedia({video: true}).then(function (stream) {
            video.src = window.URL.createObjectURL(stream);
            video.play();
        });
    }

    /* Legacy code below: getUserMedia 
     else if(navigator.getUserMedia) { // Standard
     navigator.getUserMedia({ video: true }, function(stream) {
     video.src = stream;
     video.play();
     }, errBack);
     } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
     navigator.webkitGetUserMedia({ video: true }, function(stream){
     video.src = window.webkitURL.createObjectURL(stream);
     video.play();
     }, errBack);
     } else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
     navigator.mozGetUserMedia({ video: true }, function(stream){
     video.src = window.URL.createObjectURL(stream);
     video.play();
     }, errBack);
     }
     */

// Elements for taking the snapshot
    var canvas = document.getElementById('canvas'+num);
    var context = canvas.getContext('2d');
    var video = document.getElementById('video'+num);

// Trigger photo take
    document.getElementById("snap"+num).addEventListener("click", function (event) {
        event.preventDefault();
        context.drawImage(video, 0, 0, 240, 240);
        var dataURL = canvas.toDataURL();
        $.ajax({
            type: "POST",
            url: "script.php",
            data: { 
               imgBase64: dataURL
            },
            beforeSend: function() {
                $("#roleform").html("Wait..");
            }
          }).done(function(data) {
            console.log('saved');
            $("#photoid"+num).val(data);
            $("#roleform").html("Save");
            // If you want the file to be visible in the browser 
            // - please modify the callback in javascript. All you
            // need is to return the url to the file, you just saved 
            // and than put the image in your browser.
         });
        return false;
    });
    
    
    return false;
}