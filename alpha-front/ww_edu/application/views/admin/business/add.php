
    <div class="x-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="x-content-title">
                        <h3>添加产品分类 <small>add product_sort</small></h3>
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
                            <h4><i class="glyphicon glyphicon-bell"></i>添加产品分类</h4>
                            <div class="x-box-toolbar">
                                <a href="#" class="glyphicon glyphicon-cog"></a>
                                <a href="#" class="glyphicon glyphicon-chevron-down"></a>
                                <a href="#" class="glyphicon glyphicon-remove"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form method = 'post' action = "<?=site_url(['admin','product_sort_admin','add'])?>" enctype="multipart/form-data" />
                                <div class="x-input-group">
                                    <span class="input-label">标题</span>
                                    <div class="input-control">
                                        <input type="text" name = 'title' class="form-control"/>
                                    </div>
                                </div>

                                <div class="x-input-group">
                                    <span class="input-label">描述</span>
                                    <div class="input-control">
                                        <input type="text" name = 'describe' class="form-control"/>
                                    </div>
                                </div>
                                        <input type="hidden" name = 'time' class="form-control" value = '<?=time()?>' />


                                <div class="x-input-group">
                                    <span class="input-label">图片</span>
                                    <div class="input-control">
                                        <input type="file" name = 'image' class="form-control"/>
                                    </div>
                                </div>

                                <button type = 'submit' class="btn x-btn blue">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    GO</button>
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

