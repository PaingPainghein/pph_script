<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;?
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        font {
            color: #FF0000;
        }
        .total-users {
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Server status</h1>
    <?php
    $servers = [
        'TH-01' => 'http://203.154.91.164:81/server/online',
        'Beta-1' => 'http://116.206.125.13:82/server/online',
        'Beta-2' => 'http://116.206.125.14:82/server/online',
        'Beta-3' => 'http://116.206.125.15:82/server/online',
        'Beta-4' => 'http://203.150.243.147:82/server/online',
        'Beta-5' => 'http://103.114.202.148:82/server/online',
        'Beta-6' => 'http://103.114.202.146:82/server/online',
    ];

    $totalOnlineCount = 0;

    echo '<table>';
    echo '<tr>
<th>status</th>
<th>Server</th>
</tr>';

    foreach ($servers as $serverName => $serverURL) {
        $response = @file_get_contents($serverURL);

        if ($response !== false) {
            $onlineCount = intval($response);
            echo "<tr><td>$serverName</td><td>being online <font color='#FF0000'>$onlineCount</font> คน</td></tr>";
            $totalOnlineCount += $onlineCount;
        } else {
            $error = error_get_last();
            echo "<tr><td>$serverName</td><td>Unable to connect to server - Error: " . $error['message'] . "</td></tr>";
        }
    }

    echo '</table>';

    // Check if it's taking too long to load. If so, refresh the page.
    if (connection_status() != CONNECTION_NORMAL) {
        header("Refresh:0");
    }
    echo "<div class='total-users'>All users on all servers: <font color='#3358FF'>$totalOnlineCount</font> person</div>";
    ?>
</body>
</html>
