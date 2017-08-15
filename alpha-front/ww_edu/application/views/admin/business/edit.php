<style>
    #pingfentips{
        visibility: visible;
        position: absolute;
        display: none;
        color:#000000;
        width: 100px;
        height: 50px;
        top:60px;
        left:98px;
        z-index: 2;
        background: white;

    }
    .pingfentipscent{
        border:solid 1px #9ab6a4;
        padding:5px;
        position: relative;
        z-index: 1;
    }
    #image_id{
        margin-right: 5px;
        float: left;
        width: auto;
        padding:13px;
        position: relative;
        border:.5px solid rgba(0,0,0,.3);
        border-radius: 2px;
        background: rgba(0,0,0,.1);
        box-shadow: 0 0 10px #000;
    }
    .image_show li .delimage{
        background: url("<?=base_url()?>static/css/uploadify-cancel.png") no-repeat;
        position: absolute;
        top: 0px;
        right: 0px;
        height: 15px;
        width: 15px;
    }
    ul .image_show li{
        display: inline-block;
        margin-bottom: 5px;
        width: 100px;
        padding: 5px;
        background: rgb(244, 236, 236);
    }
    .image_show li img{
        height: 150px;
        width: 150px;
    }
    #file_upload{
        float: left;
    }
    .x_box{
        overflow: hidden;
    }
    #image_show_{
        height: auto;
    }
    #file_upload{
        float: initial;
        padding-top: 10px;
    }
    #foo{
        padding: 10px;
        overflow: hidden;
    }
</style>
    <div class="x-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="x-content-title">
                        <h3>编辑 <small>Edit WEWANT</small></h3>
                    </div>
                    <ul class="breadcrumb">
                        <li>
                            <i class="glyphicon glyphicon-home"></i>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <a href="#">Layouts</a>
                        </li>
                        <li><a href="#">Horzontal Menu 2</a></li>

                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet x-box blue tabbable">
                        <div class="portlet-title clear">
                            <h4><i class="glyphicon glyphicon-bell"></i>编辑</h4>
                            <div class="x-box-toolbar">
                                <a href="#" class="glyphicon glyphicon-cog"></a>
                                <a href="#" class="glyphicon glyphicon-chevron-down"></a>
                                <a href="#" class="glyphicon glyphicon-remove"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form id="foo"/>
                                        
                               <!-- ------------------------------------------------------------------------------------ -->

                                    <div id="queue"></div>
                                    <input id="file_upload" name="file_upload" type="file" >
                                    <ul id= "image_show_" class="image_show mg-left-30">
                                        <?if(isset($datas)):?>
                                        <?foreach($datas as $v):?>
                                             <li id="image_id" attr="<?=$v['image']?>"><div class = "delimage" onclick = "del_image(this)"></div><img src ="<?=base_url()?>upload/m_<?=$v['image']?>"/>
                                                <input type="hidden" name = 'id[]' class="form-control" value = "<?=$v['id']?>" />
                                                <input type="hidden" name = 'image[]' class="form-control" value = "<?=$v['image']?>" />
                                                <div class="x-input-group">
                                                    <span class="input-label">标题</span>
                                                    <div class="input-control">
                                                        <input type="text" name = 'title[]' class="form-control" value = "<?=$v['title']?>" />
                                                    </div>
                                                </div>

                                                <div class="x-input-group">
                                                    <span class="input-label">描述</span>
                                                    <div class="input-control">
                                                        <textarea name = 'describe[]' class="form-control" ><?=$v['describe']?></textarea>
                                                    </div>
                                                </div>
                                             </li>
                                        <?endforeach;?>
                                        <?endif;?>
                                    </ul>
                                    <script type="text/html" id="image_shows">
                                            <li id="image_id" attr="<%=image%>"><div class = "delimage" onclick = "del_image(this)"></div><img src ="<?=base_url()?>upload/m_<%=image%>"/>
                                                <input type="hidden" name = 'image[]' class="form-control" value = "<%=image%>" />
                                                <div class="x-input-group">
                                                    <span class="input-label">标题</span>
                                                    <div class="input-control">
                                                        <input type="text" name = 'title[]' class="form-control" value = "" />
                                                    </div>
                                                </div>

                                                <div class="x-input-group">
                                                    <span class="input-label">描述</span>
                                                    <div class="input-control">
                                                        <textarea name = 'describe[]' class="form-control" ></textarea>
                                                    </div>
                                                </div>
                                            </li>
                                    </script>
                                <script type="text/javascript">
                                    <?php $timestamp = time();?>
                                    $(function() {
                                        $('#file_upload').uploadify({
                                            'formData'     : {
                                                'timestamp' : '<?php echo $timestamp;?>',
                                                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                                            },
                                            'swf'      : "<?=base_url()?><?=STATIC_JS?>uploadify.swf",
                                            'uploader' : "<?=site_url(array('admin_index','image','564','374'))?>",
                                            'method'   : "post",
                                            'fileObjName' : 'image',  //后台接收的时候就是$_FILES['image'] 
                                            // 'uploadLimit'   : 3, //设置最大上传文件的数量
                                            'onUploadSuccess' : function(file, data, response) 
                                            {

                                                var obj = JSON.parse(data);
                                                var image = [];          
                                                image['image'] = obj;
                                                var image_show = template.render('image_shows',image);
                                                $('#image_show_').append(image_show);
                                            },
                                        });
                                    });
                                    function del_image(obj)
                                    {
                                        $(obj.parentNode).remove();
                                    }
                                </script>

                               <!-- ---------------------------------------------------------------------------------------- -->

                                <button type = 'submit' class="btn x-btn blue">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    保存</button>

<script type="text/javascript">                           
    $("#foo").submit(function(event) {
         var ajaxRequest;

        event.preventDefault();

        $("#result").html('');
        // var images = '';
        // $("#image_show_ li").each(function()
        // {
        //     images += this.getAttribute('attr')+',';
        // })
        // images = images.slice(0,-1);
        var values = $(this).serialize();
        // values += '&image='+images;
           ajaxRequest= $.ajax({
                url: "<?=site_url(array('admin_index','edit_business'))?>",
                type: "post",
                data: values
            });

         ajaxRequest.done(function (response, textStatus, jqXHR){

              alert('保存成功')
         });

         ajaxRequest.fail(function (response){

           console.log(response);
         });
    });
</script>
                                <!-- <div class="x-input-group vertical">
                                    <span class="input-label">fasfweafaw</span>
                                    <div class="input-control">
                                        <input type="text" class="form-control"/>
                                    </div>
                                </div> -->
                                <!-- <div class="x-input-group">
                                    <label class="input-label">fafafafaf</label>
                                    <div class="input-control">
                                        <select class="form-control">
                                            <option value="category 1">category 1</option>
                                            <option value="category 2">category 2</option>
                                            <option value="category 3">category 3</option>
                                            <option value="category 4">category 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="x-input-group">
                                    <label class="input-label">fafafafaf</label>
                                    <div class="input-control ">
                                        <label class="radio">
                                            <input type="radio"/>
                                             <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="radio">
                                            <input type="radio"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="radio">
                                            <input type="radio"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="x-input-group">
                                    <label class="input-label">fafafafaf</label>
                                    <div class="input-control input-control-radio">
                                        <label class="radio-line">
                                            <input type="radio" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="radio-line">
                                            <input type="radio" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="radio-line">
                                            <input type="radio" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="x-input-group">
                                    <label class="input-label">fafafafaf</label>
                                    <div class="input-control input-control-radio">
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="x-input-group vertical">
                                    <label class="input-label">fafafafaf</label>
                                    <div class="input-control input-control-radio">
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                        <label class="checkbox-line">
                                            <input type="checkbox" name="inlineRadioOptions"/>
                                            <span class="control-explain">fafwaf</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="x-input-group">
                                    <label class="input-label">faaaaaaaa</label>
                                    <div class="input-control">
                                        <textarea rows="3"  class="form-control resize">
                                            fa
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn x-btn blue">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    save</button>
                                    <button class="btn x-btn red">
                                        <i class="glyphicon glyphicon-ok"></i>
                                        save</button>
                                    <button class="btn x-btn gray">
                                        <i class="glyphicon glyphicon-ok"></i>
                                        save</button>
                                    <button class="btn x-btn green">
                                        <i class="glyphicon glyphicon-ok"></i>
                                        save</button>
                                </div> -->
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

