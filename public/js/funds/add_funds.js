var payStatus = false;
var payInfoData = [];
// var payAmount = $("#amount").val();
// var paymentMode = $("#paymentMode").val();
// $(document).on('change', '#amount', function (e) {
//     payAmount = e.target.value;
// });

// $(document).on('change', '#paymentMode', function (e) {
//     paymentMode = e.target.value;
// });

$(document).on('click', '#cancelIcon', function (e) {
    payStatus = true;
    $("#paycard").show();
    $("#payinfo").hide();
    location = "/add_funds";
    location.reload();
});

function handlePayment() {
    if (payStatus === false) {
        payStatus = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'POST',
            url: "add_funds/payment",
            data: { payAmount: $("#amount").val(), paymentMode: $("#paymentMode").val() },
            success: function (data) {
                console.log('data', data)
                if (data.status == 200) {
                    $('#payinfotable').append(data.xml);
                    payInfoData = data;
                    $("#paycard").css("display", "none")
                    $("#payinfo").css("display", "block")
                } else if (data.status == 400) {
                    console.log(data.error); return;
                }
            }
        });
    } else {
        $("#paycard").css("display", "none")
        $("#payinfo").css("display", "block")
    }
}