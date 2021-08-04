<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error_regitration
        {
            color: red;
        }
    </style>
    <title>Mooodle Plugin</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <h3 class="text-center text-dark mt-4 mb-4" style="text-decoration: underline;">Moodle <span class="text-success">Plugin</span> Check</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="card m-auto" style="width:70%;background: #e6e6e6;">
                <div class="card-body">
                <h5 class="card-title mb-2 mt-2 text-center text-primary">Plugin Check Form</h5>
                <div class="success"></div>
                <div class="msg" style="text-align: center;color: darkred;"></div>
                <form name="plugin_form" id="plugin_form" action="" method="post" enctype='multipart/form-data'>
                    <div class="row">
                        <div class="col-8 m-auto mt-2">
                            <div class="form-group mt-2 mb-2">
                                    <label for="plugin_optionselect" class="form-label">Select Moodle Version</label>
                                    <select class="form-select" id="moodle_version" name="moodle_version">
                                       <option value="">Choose One</option>
                                        <option value="37">Moodle 3.11</option>
                                        <option value="36">Moodle 3.10</option>
                                        <option value="35">Moodle 3.9</option>
                                        <option value="34">Moodle 3.8</option>
                                        <option value="31">Moodle 3.7</option>
                                        <option value="30">Moodle 3.6</option>
                                        <option value="29">Moodle 3.5</option>
                                        <option value="27">Moodle 3.4</option>
                                        <option value="25">Moodle 3.3</option>
                                        <option value="24">Moodle 3.2</option>
                                        <option value="23">Moodle 3.1</option>
                                        <option value="21">Moodle 3.0</option>
                                        <option value="20">Moodle 2.9</option>
                                        <option value="19">Moodle 2.8</option>
                                        <option value="17">Moodle 2.7</option>
                                        <option value="15">Moodle 2.6</option>
                                        <option value="13">Moodle 2.5</option>
                                        <option value="11">Moodle 2.4</option>
                                        <option value="10">Moodle 2.3</option>
                                        <option value="8">Moodle 2.2</option>
                                        <option value="1">Moodle 2.1</option>
                                        <option value="2">Moodle 2.0</option>
                                        <option value="3">Moodle 1.9</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8 m-auto mt-2">
                            <div class="form-group mt-2 mb-2">
                                    <label for="plugin_optionselect" class="form-label">Select Plugin Option</label>
                                    <select class="form-select" name="plugin_optionselect" id="plugin_optionselect" onchange="getpluginoption()">
                                        <option value="">Choose One</option>
                                        <option value="1">CSV</option>
                                        <option value="2">Input Text</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="secondrow">
                        <div class="col-8 m-auto mt-2">
                            <div class="form-group mt-2 mb-2">

                                <label for="plugin_csv"></label>
                                <input type="file" class="form-control-file" id="plugin_csv" name="plugin_csv">
                                <div class="error_regitration plugin_csv"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="thirdrow">
                        <div class="col-8 m-auto mt-2">
                            <div class="form-group mt-2 mb-2">
                                <label for="plugin_name mb-2">Plugin Name</label>
                                <input type="text" class="form-control" id="plugin_name" name="plugin_name" placeholder="Enter plugin name">

                            </div>
                            <div id="lblError">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8  m-auto mt-4">
                            <div class="form-group text-center mt-2 mb-2">
                                <button type="reset" class="btn btn-primary ml-3" style="width:25%;">Reset</button>
                               <button type="submit" class="btn btn-primary" name="plugin_submit" id="plugin_submit" style="width:25%;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="text-center" id="showhtml" style="display:none;">
                   <img src="loading.gif" alt="">
                </div>
                <div class="text-center" id="showtable" style="display:none;">
                
                </div>
            </div>
        </div>
    </div>
     <!--------------- javascript code start ----------- -->
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
      <script>
        function ValidateExtension() {
                var allowedFiles = [".csv",".xls"];
                var fileUpload = document.getElementById("plugin_csv");
                var lblError = document.getElementById("lblError");
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                if (!regex.test(fileUpload.value.toLowerCase())) {
                    lblError.innerHTML = "Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.";
                    return false;
                }
                lblError.innerHTML = "";
                return true;
            }
          function getpluginoption()
          {
              var x = $('#plugin_optionselect').val();
              switch (x) {
                  case '1':
                      $('#secondrow').show();
                      $('#thirdrow').hide();
                      
                      break;
                  case '2':
                      $('#thirdrow').show();
                      $('#secondrow').hide();
                      break;
                  default:
                    $('#secondrow').hide();
                    $('#thirdrow').hide();
                      break;
              }
          }

          $("#plugin_form").validate({
            errorClass:'error_regitration',
            errorElement: 'span',
            rules:{
                moodle_version:{
                required:true
              },
              plugin_optionselect:{
                required:true
              },
            },
            messages:{
                moodle_version:{
                required:"Please Select Moodle Version."
              },
              login_otp:{
                required:"Please Select File Type."
              },
            },
            submitHandler:function(form){
                    $('#showhtml').show();
                    $('#plugin_submit').attr('disabled','disabled');
                    $('#plugin_submit').text('processing .....');
                    $('#showtable').hide();
                    $.ajax({
                        url: 'ajax_curl.php',
                        type: 'POST',
                        data: new FormData(form),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data){
                          $("#plugin_submit").removeAttr('disabled');
                          $("#plugin_submit").text('Submit'); 
                          $('#showhtml').hide(); 
                         
                          if(data.status){
                            var content = " <h5 class='text-center mt-3 mb-5' style='text-decoration:underline;'>Plugin Update Result</h5><table class='table table-bordered mb-5' style='background: #f5f5f5;'>"
                            content += '<thead style="background: #afddef;"><tr><th>S.No.</th>';
                            content += '<th>Plugin Name</th>';
                            content += '<th>Available</th>';
                            content += '<th>Download</th></tr>';
                            content += '</thead><tbody>';
                            var i=1;
                            var ddlink;
                            $.each(data.result , function(index, val) {
                                if(val.downloadlink!="")
                                {
                                    ddlink='<a class="btn btn-success" '+ val.downloadlink + ' >Download</a>';
                                }
                                else
                                {
                                    ddlink="-----";
                                }
                                content += '<tr><td>'+ i++ + '</td>';
                                content += '<td>'+ val.short_name + '</td>';
                                content += '<td>'+ val.result + '</td>';
                                content += '<td>'+ ddlink +'</td></tr>';
                            });
                            content += "</tbody></table>"
                            $('#showtable').show();
                            $('#showtable').html(content);
                          }else{
                              if(data.errors){
                                  $('.plugin_csv').text(data.errors.plugin_csv);
                              }else{
                                  $(".msg").text(data.error);
                              }
                          }
                        }
                    });
                }
            });

      </script>

</body>
</html>
