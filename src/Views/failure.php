<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Failed</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md text-center">
        <h2 class="text-2xl font-bold text-red-600">Payment Failed</h2>
        <p class="mt-2 text-gray-700">Unfortunately, your payment could not be processed.</p>
        
        <div class="mt-4 p-4 bg-gray-50 rounded-md">
            <h3 class="text-lg font-semibold text-gray-800">Reason for Failure</h3>
            <p class="text-sm text-gray-600">Possible reasons:</p>
            <ul class="mt-2 text-sm text-gray-600 text-left list-disc list-inside">
                <li>Insufficient funds</li>
                <li>Invalid card details</li>
                <li>Technical error</li>
            </ul>
        </div>

        <a href="./checkout" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            Try Again
        </a>

    </div>

</body>
</html>
