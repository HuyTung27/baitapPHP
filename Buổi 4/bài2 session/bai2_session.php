<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <form id="paymentUploadForm" action="bai2_sessions.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <h1>Payment Receipt Upload Form</h1>
            <table>
                <tr>
                    <td>
                        <label for="first_name">Name</label><br>
                        <div class="placeholder">First Name</div>
                        <input type="text" id="first_name" name="first_name">
                        
                    </td>
                    <td>
                        <label for="last_name">&nbsp;</label><br>
                        <div class="placeholder">Last Name</div>
                        <input type="text" id="last_name" name="last_name">
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="email">Email</label><br>
                        <input type="email" id="email" name="email_address">
                        <div class="placeholder">example@example.com</div>
                    </td>
                    <td>
                        <label for="invoidID">Invoice ID</label><br>
                        <input type="text" id="invoidID" name="invoice_id">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="pay">Pay For</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option1" name="payment_options[]" value="15K Category">
                            <label for="option1">15K Category</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option2" name="payment_options[]" value="55K Category">
                            <label for="option2">55K Category</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option3" name="payment_options[]" value="116K Category">
                            <label for="option3">116K Category</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option4" name="payment_options[]" value="Shuttle Two Ways">
                            <label for="option4">Shuttle Two Ways</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option5" name="payment_options[]" value="Comperssport T-Shirt Merchandise">
                            <label for="option5">Comperssport T-Shirt Merchandise</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option6" name="payment_options[]" value="Other">
                            <label for="option6">Other</label>
                        </div>
                    </td>
                    <td>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option7" name="payment_options[]" value="35K Category">
                            <label for="option7">35K Category</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option8" name="payment_options[]" value="75K Category">
                            <label for="option8">75K Category</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option9" name="payment_options[]" value="Shuttle One Way">
                            <label for="option9">Shuttle One Way</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option10" name="payment_options[]" value="Tranning Cap Merchandise">
                            <label for="option10">Tranning Cap Merchandise</label>
                        </div>
                        <div class="checkbox-label">
                            <input type="checkbox" id="option11" name="payment_options[]" value="Buf Merchandise">
                            <label for="option11">Buf Merchandise</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <label for="pay">Please upload your payment receipt</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="file" name="fileUpload" id="fileUpload" accept=".jpg, .jpeg, .png, .gif" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">Additional Information</td>
                </tr>

                <tr>
                    <td colspan="4"><textarea name="ad_inf" placeholder=" Typy here"></textarea></td>
                </tr>
            </table>

                <button type="submit">Submit</button>
        </fieldset>
    </form>
</body>
</html>
