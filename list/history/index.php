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
    <style>
        :root {
            --primary-color: #4c1d95;
            --secondary-color: #ffffff;
            --accent-color: #6366f1;
            --success-color: #10b981;
            --error-color: #ef4444;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --hover-bg: #f3f4f6;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --alternate-bg: #f9fafb;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-primary);
            background: linear-gradient(135deg, #f0f4ff 0%, #e0e7ff 100%);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-nav {
            background-color: var(--secondary-color);
            padding: 1rem;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .nav-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .back-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-primary);
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: background-color 0.2s;
        }

        .back-btn:hover {
            background-color: var(--hover-bg);
        }

        .history-container {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            flex: 1;
        }

        .tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .tab {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 3px solid transparent;
        }

        .tab:hover {
            background-color: var(--hover-bg);
        }

        .tab.active {
            color: var(--primary-color);
            border-bottom: 3px solid var(--primary-color);
        }

        .transaction-list {
            max-height: 60vh;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .transaction-item {
            background-color: var(--alternate-bg);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid var(--primary-color);
        }

        .transaction-details {
            flex: 1;
        }

        .transaction-type {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
        }

        .transaction-amount {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0.25rem 0;
        }

        .transaction-date {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .transaction-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 500;
        }

        .status-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-failed {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .no-transactions {
            text-align: center;
            color: var(--text-secondary);
            font-style: italic;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .history-container {
                padding: 1rem;
            }

            .tabs {
                gap: 0.5rem;
            }

            .tab {
                font-size: 1rem;
                padding: 0.5rem;
            }

            .transaction-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .transaction-status {
                align-self: flex-end;
            }
        }

        @media (max-width: 480px) {
            .nav-title {
                font-size: 1rem;
            }

            .back-btn {
                font-size: 1.25rem;
            }

            .tab {
                font-size: 0.875rem;
                padding: 0.4rem 0.8rem;
            }

            .transaction-item {
                padding: 0.75rem;
            }

            .transaction-amount {
                font-size: 0.875rem;
            }

            .transaction-date {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
   

    <div class="container">
        <!-- Top Navigation -->
     <?php include '../../include/user_top_navbar.php';?>
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
<br><br> <br>
    <!-- Footer -->
    <!--?php include '../../include/footer.php'; ?-->

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