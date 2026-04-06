
function get_admin_action_log()
{
    var url = '/beta/api/admin/getAdminActionLog/format/json';

    var data = 'code=1';

    $.post(url, data, function(data)
    {
        $('#admin-action-log').html(data.data);
        $('#admin-action-log').show(500);

    }, 'json');

}
function get_player_action_log()
{
    var url = '/beta/api/admin/getPlayerActionLog/format/json';

    var data = 'code=1';

    $.post(url, data, function(data)
    {
        $('#player-action-log').html(data.data);
        $('#player-action-log').show(500);

    }, 'json');


}
function get_online_list()
{
    var url = '/beta/api/admin/getSiteVisitors/format/json';
    var data = 'code=1';

    $.post(url, data, function(data)
    {
        $('#online-list').html(data.data);
        $('#online-list').show(500);

    }, 'json');


}

(function($) {
    $(function() {

        $('#admin-action-log').hide();
        $('#player-action-log').hide();
        $('#online-list').hide();


        var options = [
            {selector: '.admin-action-log', offset: 0, callback: 'get_admin_action_log()'},
            {selector: '.player-action-log', offset: 0, callback: 'get_player_action_log()'},
            {selector: '.online-list', offset: 0, callback: 'get_online_list()'}

        ];
        Materialize.scrollFire(options);

    }); // end of document ready
})(jQuery); // end of jQuery name space
