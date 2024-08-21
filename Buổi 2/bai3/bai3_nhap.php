<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            margin: 20px auto; /* Center the container horizontally */
        }
        h2 {
            margin-top: 0;
            color: #333;
        }
        .phep_tinh {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .phep_tinh1 {
            display: flex;
            align-items: center;
        }
        .phep_tinh1 input {
            margin-right: 5px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>PHÉP TÍNH TRÊN 2 SỐ</h2>
        <form method="post" action="bai3_ketqua.php">
            <div class="phep_tinh">
                <div class="phep_tinh1">
                    <input type="radio" name="operation" value="Cộng" id="add"> 
                    <label for="add">Cộng</label>
                </div>
                <div class="phep_tinh1">
                    <input type="radio" name="operation" value="Trừ" id="subtract"> 
                    <label for="subtract">Trừ</label>
                </div>
                <div class="phep_tinh1">
                    <input type="radio" name="operation" value="Nhân" id="multiply"> 
                    <label for="multiply">Nhân</label>
                </div>
                <div class="phep_tinh1">
                    <input type="radio" name="operation" value="Chia" id="divide"> 
                    <label for="divide">Chia</label>
                </div>
            </div>

            <label for="number1">Số thứ nhất:</label>
            <input type="text" id="number1" name="number1">

            <label for="number2">Số thứ hai:</label>
            <input type="text" id="number2" name="number2">

            <input type="submit" value="Tính">
        </form>
    </div>
</body>
</html>
