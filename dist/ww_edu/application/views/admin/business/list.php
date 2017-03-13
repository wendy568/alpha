
        <div class="x-content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x-content-title">
                            <h3>product_sort <small>分类列表</small></h3>
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
                        <div class="portlet x-box blue">
                            <div class="portlet-title clear">
                                <h4><i class="glyphicon glyphicon-bell"></i>分类列表</h4>
                                <div class="x-box-toolbar">
                                    <a href="#" class="glyphicon glyphicon-cog"></a>
                                    <a href="#" class="glyphicon glyphicon-chevron-down x-fn-zooming"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row deInfo">
                                    <div class="col-md-9">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Dropdown
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="#">Action</a></li>
                                                <li><a href="#">Another action</a></li>
                                                <li><a href="#">Something else here</a></li>
                                                <li><a href="#">Separated link</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search for...">
                                              <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                              </span>
                                        </div><!-- /input-group -->
                                    </div>
                                </div>
                                <table class="table table-bordered  table-striped  x-table">
                                    <tr>
                                        <th class="x-table-filerate top">编号</th>
                                        <th class="x-table-filerate bottom">标题</th>
                                        <th class="x-table-filerate top">描述</th>
                                         <th class="x-table-filerate top">时间</th>
                                        <th class="x-table-filerate top">操作</th>
                                    </tr>
                                    <?php foreach($product_sort as $v): ?>
                                    <tr>
                                         <!-- label-info label-primary label-warning -->
                                        <td><?=$v['id']?></td>
                                        <td><?=$v['title']?></td>
                                        <td><span class="label label-danger"><?=$v['describe']?></span></td>
                                        <td><?=$v['time']?></td>
                                        <td>
                                            <!-- <a href="" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-edit"></span>编辑</a> -->
                                            <a href="<?=site_url(['admin','product_sort_admin','edit',$v['id']])?>" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span>修改</a>
                                            <a href="<?=site_url(['admin','product_sort_admin','delete',$v['id']])?>" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span>删除</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
