Bits on the Run JavaScript Uploads
----------------------------------

This document describes how the JavaScript based upload script for
Bits on the Run can be used.

There are two types of uploads to Bits on the Run:
- The classic method consists of uploading a file in its entirety and
  optionally calling the API to get information about the upload
  progress.
- Many newer browsers may benefit from their support of the file APIs,
  by allowing resumable uploads. Using this approach, files are uploaded
  in small chunks. After each chunk, it is possible to pause the
  upload, and to find out the progress.
  It is also possible to resume an upload after it has stalled, for
  example due to loss of network connectivity.

Because many browsers do not yet support resumable uploads, the upload
script supports both approaches.


How to use
----------

A file upload to Bits on the Run follows an API call.
These API calls (for example: /videos/create) have a response which
contains a "link" object. Additionally, for resumable uploads, there is
a "session_id" string.

= Non-resumable uploads =

In order to create a non-resumable upload, the following code suffices:

  var upload = new BotrUpload(link);

Where link is the "link" object in the API response.
The upload script may generate a form to be placed on the page.
In order to do so, the following code can be used in the "onload" phase
of your page:

  var uploadForm = upload.getForm();
  document.getElementById('target').appendChild(uploadForm);

Or when using JQuery:

  var uploadForm = upload.getForm();
  $('#target').append(uploadForm);

This appends the form directly to an element with id="target".
The form contains a single file input element.
It is possible to add a submit button to the form:

  var submitButton = document.createElement('input');
  submitButton.setAttribute('type', 'submit');
  uploadForm.appendChild(submitButton);
  
Or in JQuery:

  var submitButton = $('<input>').attr('type', 'submit');
  $(uploadForm).append(submitButton);

It is also possible to automatically start the upload using JavaScript:

  upload.start();

Because the form submission transfers the user to a JSON response page,
unless a redirect link is given (see section "Options"), it is
recommended to use the following code:

  document.body.appendChild(upload.getIframe());

Or using JQuery:

  $('body').append(upload.getIframe());
  
This causes uploads to be done in the background. When the upload is
done, the user is no longer transfered to another page.

= Resumable uploads =

To check if resumable uploads are supported, 
BotrUpload.resumeSupported() can be called. This returns whether the
browser is capable of uploading using the file API. 

In order to create a resumable upload, the following code is used:

  var upload = new BotrUpload(link, session_id);
  
Where link is the "link" object in the API response and session_id is
the "session_id" string in the API response.

A form is embedded in the same way as described in section
"Non-resumable uploads", however uploads are always done in the
background, and thus using the iframe is not required (and not
recommended).

= Callbacks =

There are five callbacks which can be used from JavaScript:
- onSelected()
  This is called when a file is selected using the file input element in
  the form.
- onStart()
  This is called just before the file upload is started.
- onProgress(bytes, total)
  This is called periodically, while the upload is busy.
  It can be used to implement a progress bar.
- onCompleted(size, redirect)
  This is called once after an upload is finished.
  It contains an optional url to which the user should be redirected.
- onError(message)
  This is called once after an upload is unsuccesful because of an
  error.

An example of a custom callback is the following:

  upload.onError = function(message) {
    alert("An error occurred! " + message);
  };

= Options =

- Redirect link
  In order to set a redirect link, the upload object must be created as
  follows:
  
    var upload = new BotrUpload(link, session_id, redirect);
  
  Where link is the "link" is the same as described above, session_id is
  the "session_id" string from the API response if the upload is
  resumable, or false otherwise, and redirect is an object similar to
  the one below:
  
    var link = {
      'url': 'http://example.com/',
      'params': {
        'msg': 'Success!'
      }
    };
    
  Here, the 'params' entry is optional, and represents the GET
  parameters for the target. The example would produce the following
  url: "http://example.com/?msg=Success!"

- Chunk size

  For resumable uploads, it is possible to change the size of the
  chunks:
  
    upload.chunkSize = 1024 * 1024 * 4; // 4 MiB per chunk
  
  Larger chunks are slightly faster, but cause the progress callback to
  be called less often.

- Poll interval

  For non-resumable uploads, it is possible to change the interval
  between two upload progress polls:
  
    upload.pollInterval = 1000; // Wait 1000 ms between progress polls

- Verbosity

  By default, the script adds debug information to the JavaScript
  console if possible.
  To disable this behavior, the following code can be used:
  
    upload._log = function(msg) { };


Browser support
---------------

Non-resumable uploads are supported in all major desktop browsers.
This includes Internet Explorer 6 and later, Mozilla Firefox,
Google Chrome and Opera.
Resumable uploads are not widely supported, but a method is provided to
check for support.
