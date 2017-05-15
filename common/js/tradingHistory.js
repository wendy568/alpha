(function () {
    $('.filter').click(function(){
      $('.c-title').toggleClass('hide');
    });
    
    $('.c-title li input').click(function (e) {
        e.stopPropagation();
        window.event.stopPropagation();
        
        var isShow =  $(this).prop('checked');
        var index = parseInt($(this).val());
        var $thead = $('.table thead tr th:nth-child('+index+')');
        var $td = $('.table tbody tr td:nth-child('+index+')');
        if(isShow){
            $thead.show();
            $td.show();
        }else{
            $thead.hide();
            $td.hide();
        }
    });

    getTableData();
    
    $('#today').click(function (e) {
        e.stopPropagation();
        var today = new Date();
        var bill = $('.bill-type select').val() || null;
        $('.date input').val(today.Format('MM/dd/yyyy'));
        getTableData(bill,today.Format('MM/dd/yyyy'),today.Format('MM/dd/yyyy'));
    });

    $('#search').click(function (e) {
        e.stopPropagation();
        var bill = $('.bill-type select').val() || null;
        var startTime = $('.date input').eq(0).val();
        var endTime = $('.date input').eq(1).val();
        getTableData(bill,startTime,endTime);
    });
    
    /*$('.bill-type select').change(function (e) {
    	  e.stopPropagation();
    	  var curBill = $(this).val();
        $.each($('.table tbody tr'),function (i,tr) {
            var bill = $(tr).find('td').eq(0).find('span').html();
            if(curBill != 'all'){
                bill == curBill ? $(this).show() : $(this).hide();
            }else{
                $(this).show();
            }
        });
    });*/

    $('.account select').change(function (e) {
        e.stopPropagation();
        $('.bill-type select').val(' ');
        var curAccount = $(this).val();
        // todo request
    });
    
    // 获取列表数据
    function getTableData(bill,startTime,endTime,curPage) {
        startTime = startTime ? parseInt((new Date(startTime).getTime())/1000) : null;
        endTime = endTime ? parseInt((new Date(endTime).getTime())/1000) : null;
        bill && (bill = bill.replace('/',''));
        var data = {
            finency_proc : bill,
            start_time : startTime,
            end_time : endTime
        };
        
        $.alpha.request_Url('POST','Trading_Analysis/trading_history',data,function (res) {
            if(res.archive.status == 0){
            	  var list = res.data.trading_history;
                var reg = new RegExp(/^[A-Z]{6}$/);
                $('.table tbody').empty();
            	  $.each(list,function (i,row) {
            	  	  var bill = '';
            	  	  var openTime = new Date(parseInt(row.order_open_time)*1000);
            	  	  var closeTime = new Date(parseInt(row.order_close_time)*1000);
            	  	  if(row.order_symbol.length == 6 && row.order_symbol != 'COPPERssss' && reg.test(row.order_symbol)){
                        var x = row.order_symbol.substring(0,3);
                        var y = row.order_symbol.substring(3);
                        bill = x + '/' + y;
                    }else{
            	  	  	  bill = row.order_symbol;
                    }
                    var $td = '';
                    $td += '<td><span class="text-c1">'+bill+'</span></td>';
                    $td += '<td><span class="text-c2">'+row.order_no+'</span></td>';
                    $td += '<td><span class="text-c2">'+openTime.Format("yyyy.MM.dd hh:mm")+'</span></td>';
                    $td += '<td><span class="text-c2">'+row.order_lots+'</span></td>';
                    $td += '<td><span class="label label-'+(row.order_type == 1 ? 'important' : 'success')+' m-l-5">'+(row.order_type == 1 ? 'Sell' : 'Buy')+'</span></td>';
                    $td += '<td class="text-'+(row.profit >= 0 ? 'success' : 'error')+'">'+(row.profit >= 0 ? '$'+row.profit : '-$'+Math.abs(row.profit))+'</td>';
                    $td += '<td class="text-right"><span class="text-c2">'+closeTime.Format("yyyy.MM.dd")+'</span></td>';
                    var $tr = $('<tr class="m-t-30 preview local_'+i+'" data-account="'+row.account_number+'">'+$td+'</tr>');
                    $('.table tbody').append($tr);
                });
            }
        });
    }
})();