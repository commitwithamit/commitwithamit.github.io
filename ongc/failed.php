<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ONGC | No Internet</title>
    <style>
        @font-face {
            font-family: poppins;
            src: url(fonts/Poppins-Regular);
        }
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body{
            display: grid;
            align-items: center;
            justify-items: center;
            grid-template-rows: 100vh;
            font-family: 'poppins';
            flex-wrap: wrap;
        }
        .texts{
            text-align: center;
            margin-top: 10px;
        }
        @media screen and (min-width:992px){
            h4{
                font-size: 2rem;
            }
            p{
                font-size: 1.3rem;    
            }
        }
    </style>
</head>
<body>
    <div>
        <img src="images/no-internet.svg" alt="No Internet">
        <div class="texts">
            <h4>Ops! Something Went Wrong</h4>
            <p>Please Check your internet connection.</p>
        </div>
    </div>
</body>
</html>