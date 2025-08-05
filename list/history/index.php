 <?php
    // session_start();

    // Sample transaction data (in a real application, this would come from a database)
    $all_transactions = [
        [
            'type' => 'Data Purchase',
            'amount' => '1000',
            'date' => '2025-07-30 14:30:00',
            'status' => 'successful'
        ],
        [
            'type' => 'Airtime Purchase',
            'amount' => '500',
            'date' => '2025-07-29 09:15:00',
            'status' => 'successful'
        ],
        [
            'type' => 'Bonus Received',
            'amount' => '200',
            'date' => '2025-07-28 16:45:00',
            'status' => 'successful'
        ],
        [
            'type' => 'Data Purchase',
            'amount' => '2000',
            'date' => '2025-07-27 11:20:00',
            'status' => 'failed'
        ]
    ];

    $funding_transactions = [
        [
            'type' => 'Manual Funding',
            'amount' => '5000',
            'date' => '2025-07-30 10:00:00',
            'status' => 'successful'
        ],
        [
            'type' => 'Auto Funding',
            'amount' => '3000',
            'date' => '2025-07-29 15:30:00',
            'status' => 'successful'
        ],
        [
            'type' => 'Manual Funding',
            'amount' => '10000',
            'date' => '2025-07-28 08:45:00',
            'status' => 'failed'
        ]
    ];
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - atPay</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
 <link rel="stylesheet" href="index.css">
</head>
<body>
   

    <div class="container">
        <!-- Top Navigation -->
     <?php include '../../user/notification/navbar.php';?>
        <center><div class="nav-title">Transaction History</div>
            <div style="width: 1.5rem; "></div> <!-- Spacer for alignment -->
</center>
        <!-- History Container -->
        <div class="history-container">
            <div class="tabs">
                <div class="tab active" id="transactions-tab" onclick="showTransactions()">Transactions</div>
                <div class="tab" id="funding-tab" onclick="showFunding()">Funding</div>
            </div>
            <div class="transaction-list" id="transactions-list">
                <?php if (empty($all_transactions)): ?>
                    <div class="no-transactions">No transactions found</div>
                <?php else: ?>
                    <?php foreach ($all_transactions as $transaction): ?>
                        <div class="transaction-item">
                            <div class="transaction-details">
                                <div class="transaction-type"><?php echo htmlspecialchars($transaction['type']); ?></div>
                                <div class="transaction-amount">₦<?php echo number_format($transaction['amount'], 0); ?></div>
                                <div class="transaction-date"><?php echo htmlspecialchars($transaction['date']); ?></div>
                            </div>
                            <div class="transaction-status status-<?php echo strtolower($transaction['status']); ?>">
                                <?php echo ucfirst(htmlspecialchars($transaction['status'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="transaction-list" id="funding-list" style="display: none;">
                <?php if (empty($funding_transactions)): ?>
                    <div class="no-transactions">No funding transactions found</div>
                <?php else: ?>
                    <?php foreach ($funding_transactions as $transaction): ?>
                        <div class="transaction-item">
                            <div class="transaction-details">
                                <div class="transaction-type"><?php echo htmlspecialchars($transaction['type']); ?></div>
                                <div class="transaction-amount">₦<?php echo number_format($transaction['amount'], 0); ?></div>
                                <div class="transaction-date"><?php echo htmlspecialchars($transaction['date']); ?></div>
                            </div>
                            <div class="transaction-status status-<?php echo strtolower($transaction['status']); ?>">
                                <?php echo ucfirst(htmlspecialchars($transaction['status'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

   <?php include '../../include/app_settings.php'; ?>
        <footer style="text-align:center; font-size:14px; color:var(--secondary-color); background-color:var(--primary-color); padding:20px 0;">
            <?php echo APP_NAME_FOOTER; ?>
        </footer>

    <script>
        const transactionsTab = document.getElementById('transactions-tab');
        const fundingTab = document.getElementById('funding-tab');
        const transactionsList = document.getElementById('transactions-list');
        const fundingList = document.getElementById('funding-list');

        function showTransactions() {
            transactionsList.style.display = 'block';
            fundingList.style.display = 'none';
            transactionsTab.classList.add('active');
            fundingTab.classList.remove('active');
        }

        function showFunding() {
            transactionsList.style.display = 'none';
            fundingList.style.display = 'block';
            transactionsTab.classList.remove('active');
            fundingTab.classList.add('active');
        }

        // Initialize with transactions visible
        showTransactions();
    </script>
</body>
</html>