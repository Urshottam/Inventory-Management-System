<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $quantity = $_GET['quantity'];
    // echo $quantity;
    $price = $_GET['price']*$quantity;
    // $_SESSION['quantity'] = $quantity;
    
    ?>
    <form method="post" id="shippingForm">
        <input type="hidden" id="amount" name="amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="tax_amount" name="tax_amount" value="0" required>
        <input type="hidden" id="total_amount" name="total_amount" value="<?php echo (int)$price; ?>" required>
        <input type="hidden" id="transaction_uuid" name="transaction_uuid" required>
        <input type="hidden" id="product_code" name="product_code" value="EPAYTEST" required>
        <input type="hidden" id="product_service_charge" name="product_service_charge" value="0" required>
        <input type="hidden" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
        <!-- http://localhost/Summerproject/customer/place_order.php -->
        <input type="hidden" id="success_url" name="success_url" value="http://localhost/Summerproject/customer/success.php" required>
        <input type="hidden" id="failure_url" name="failure_url" value="http://localhost/Summerproject/customer/failure.php?param1=value1" required>
        <input type="hidden" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
        <input type="hidden" id="signature" name="signature" required>
    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/crypto-js.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/hmac-sha256.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1
/enc-base64.min.js"></script>
    <script>
        var uuid = performance.now();
        var id = `${uuid}`.replace('.', '-');

        var tuid = document.getElementById('transaction_uuid');
        var secret = '8gBm/:&EnhH.1/q';
        var signature = `total_amount=<?php echo $price; ?>,transaction_uuid=${id},product_code=EPAYTEST`;

        var hash = CryptoJS.HmacSHA256(signature, secret);
        var hashInBase64 = CryptoJS.enc.Base64.stringify(hash);

        var sig = document.getElementById('signature');
        tuid.value = id;
        sig.value = hashInBase64;

        if (hashInBase64) {
            myFunction();
        }
        let userDetails;

        function storeFormData() {
            var fullNameInput = document.getElementById('full_name');
            var addressInput = document.getElementById('address');
            var cityInput = document.getElementById('city');
            var phoneInput = document.getElementById('phone');

            sessionStorage.setItem('full_name', fullNameInput.value);
            sessionStorage.setItem('address', addressInput.value);
            sessionStorage.setItem('city', cityInput.value);
            sessionStorage.setItem('phone', phoneInput.value);

        }

        document.getElementById('shippingForm').addEventListener('submit', function(event) {
            storeFormData();
        });

        function myFunction() {
            var formElem = document.getElementById('shippingForm');
            formElem.setAttribute('action', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form');
            formElem.submit();
        }
    </script>
</html>
