/**
 * Created by junyv on 2018/4/3.
 */
var Lists = {
    page         : 2,//当前页码
    totalPage    : $('#lists').data('total') || 1,//总页码
    requestParam : {},//请求参数
    requestUrl   : $('#lists').data('uri'),//请求url
    loadMore     : 'load-more',
    getData      : function(){
        var that = this;
        this.requestParam.page = this.page;
        if(this.page <= this.totalPage){
            $('#'+this.loadMore).addClass('loading').text('数据加载中……');
            $.get(this.requestUrl,this.requestParam,function(result){
                if(result.code == 1)
                {
                    that.page++;
                    var gettpl = document.getElementById('template').innerHTML;
                    laytpl(gettpl).render(result.data.houselist, function(html){
                        $('#lists').append(html);
                    });
                    $('#lists').attr('data-total',result.data.total_page);
                    if(that.page > that.totalPage || that.page > result.data.total_page){
                        $('#'+that.loadMore).text('数据加载完成');
                    }else{
                        $('#'+that.loadMore).removeClass('loading').text('加载更多');
                    }
                }else{
                    console.log(result.msg);
                }
            });
        }
    }
};