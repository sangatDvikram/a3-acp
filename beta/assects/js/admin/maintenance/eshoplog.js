(function($) {
    $(function() {

 $('#eshoplog').dataTable( {
        "processing": true,
        "serverSide": true,
        "ajax":
                    {
                        "url": "/beta/api/eshop/transactionlogs/format/json",
                        "type": "POST"
                    },
        "deferLoading": total_transaction,
        "scrollX": true
    } );

       
    }); // end of document ready
})(jQuery); // end of jQuery name space



