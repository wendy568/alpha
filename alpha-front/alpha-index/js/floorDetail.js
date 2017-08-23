(function(){
	// Modal-Table
    $('.custom').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('.camp').click(function(){
        $(this).addClass('active').siblings().removeClass('active');
    });

   // default total
    $('.total').html( "€ 99.00 * 1 = € 99.00");

    new YMDselect('year1','month1','day1');

    // 点击图片放大查看-------------------------------------------------------------------------------------------------------------
    var viewer = new Viewer(document.getElementById('photos'), {
        url: 'data-original'
    });

    // window.onload = function(){
        // 百度地图API功能
        var map = new BMap.Map("map");
        var point = new BMap.Point(-2.2345,53.48045);
        map.centerAndZoom(point,18);
        map.enableScrollWheelZoom(true);
        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);              // 将标注添加到地图中
        map.panTo(point);  
        var label = new BMap.Label("3A,1Portland Street, Manchester",{offset:new BMap.Size(0,-25)});
        label.setStyle({
                 color : "white",
                 fontSize : "12px",
                 height : "20px",
                 lineHeight : "20px",
                 fontFamily:"微软雅黑",
                 border:0,
                 borderRadius:'4px',
                 background:'#000',
                 width:"190px",
                 maxWidth:'none'
                 
             });
        marker.setLabel(label); 
    // } 
})();