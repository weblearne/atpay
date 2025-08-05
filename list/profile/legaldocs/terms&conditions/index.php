<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy & Terms of Service - atPay</title>
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

        .legal-section {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            flex: 1;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .subsection-title {
            font-size: 1.25rem;
            font-weight: 500;
            color: var(--text-primary);
            margin: 1.5rem 0 1rem;
        }

        .legal-content {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .legal-content p {
            margin-bottom: 1rem;
        }

        .legal-content ul {
            list-style-type: decimal;
            padding-left: 2rem;
            margin-bottom: 1rem;
        }

        .legal-content ul li {
            margin-bottom: 0.5rem;
        }

        .legal-content ul ul {
            list-style-type: lower-roman;
            padding-left: 2rem;
            margin-top: 0.5rem;
        }

        .legal-content strong {
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            .container {
                padding: 0.75rem;
            }

            .top-nav {
                padding: 0.75rem;
            }

            .nav-title {
                font-size: 1rem;
            }

            .back-btn {
                font-size: 1.25rem;
            }

            .legal-section {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .subsection-title {
                font-size: 1.125rem;
            }

            .legal-content {
                font-size: 0.875rem;
            }
        }

        @media (max-width: 480px) {
            .nav-title {
                font-size: 0.875rem;
            }

            .back-btn {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.125rem;
            }

            .subsection-title {
                font-size: 1rem;
            }

            .legal-content {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Navigation -->
        <?php include '../../../../include/user_top_navbar.php';?>
        <br>
        <!-- Legal Documents Section -->
        <div class="legal-section">
            <h2 class="section-title">Privacy Policy & Terms of Service - atPay</h2>
            <div class="legal-content">
                <h3 class="subsection-title">1. Acceptance of Terms</h3>
                <p>atPay provides a collection of online resources, including but not limited to data bundle internet/mobile browsing, air time/recharge cards, classified ads, forums, and various email services, (referred to hereafter as "the Service") subject to the following Terms of Use ("TOU"). By using the Service in any way, you are agreeing to comply with the TOU. In addition, when using particular atPay services, you agree to abide by any applicable posted guidelines for all atPay services, which may change from time to time. Should you object to any term or condition of the TOU, any guidelines, or any subsequent modifications thereto or become dissatisfied with atPay in any way, your only recourse is to immediately discontinue use of atPay. atPay has the right, but is not obligated, to strictly enforce the TOU through self-help, community moderation, active investigation, litigation, and prosecution.</p>

                <h3 class="subsection-title">2. Modifications to This Agreement</h3>
                <p>We reserve the right, at our sole discretion, to change, modify, or otherwise alter these terms and conditions at any time. Such modifications shall become effective immediately upon the posting thereof. You must review this agreement on a regular basis to keep yourself apprised of any changes.</p>

                <h3 class="subsection-title">3. Conduct</h3>
                <p>You agree not to:</p>
                <ul>
                    <li>Create multiple accounts or violate any prohibition/restriction/limit placed on accounts on our website as this will lead to termination of your account and you will forfeit all funds in your account;</li>
                    <li>Contact anyone who has asked not to be contacted, or make unsolicited contact with anyone for any commercial purpose;</li>
                    <li>"Stalk" or otherwise harass anyone;</li>
                    <li>Collect personal data about other users for commercial or unlawful purposes;</li>
                    <li>Use automated means, including spiders, robots, crawlers, data mining tools, or the like to download data from the Service - unless expressly permitted by atPay;</li>
                    <li>Post non-local or otherwise irrelevant Content, repeatedly post the same or similar Content, or otherwise impose an unreasonable or disproportionately large load on our infrastructure;</li>
                    <li>Post the same item or service in more than one classified category or forum, or in more than one metropolitan area;</li>
                    <li>Attempt to gain unauthorized access to atPay's computer systems or engage in any activity that disrupts, diminishes the quality of, interferes with the performance of, or impairs the functionality of, the Service or the website;</li>
                    <li>Use any form of automated device or computer program that enables the submission of postings on atPay without each posting being manually entered by the author thereof (an "automated posting device"), including without limitation, the use of any such automated posting device to submit postings in bulk, or for automatic submission of postings at regular intervals;</li>
                    <li>Use any form of automated device or computer program ("flagging tool") that enables the use of atPay's "flagging system" or other community moderation systems without each flag being manually entered by the person that initiates the flag (an "automated flagging device"), or use the flagging tool to remove posts of competitors, or to remove posts without a good faith belief that the post being flagged violates these TOU;</li>
                </ul>
                <p>Additionally, you agree not to post, email, or otherwise make available Content:</p>
                <ul>
                    <li>That is unlawful, harmful, threatening, abusive, harassing, defamatory, libelous, invasive of another's privacy, or is harmful to minors in any way;</li>
                    <li>That is pornographic or depicts a human being engaged in actual sexual conduct including but not limited to:
                        <ul>
                            <li>Sexual intercourse, including genital-genital, oral-genital, anal-genital, or oral-anal, whether between persons of the same or opposite sex;</li>
                            <li>Bestiality;</li>
                            <li>Masturbation;</li>
                            <li>Sadistic or masochistic abuse;</li>
                            <li>Lascivious exhibition of the genitals or pubic area of any person;</li>
                        </ul>
                    </li>
                    <li>That harasses, degrades, intimidates, or is hateful toward an individual or group of individuals on the basis of religion, gender, sexual orientation, race, ethnicity, age, or disability;</li>
                    <li>That violates the Fair Housing Act by stating, in any notice or ad for the sale or rental of any dwelling, a discriminatory preference based on race, color, national origin, religion, sex, familial status, or handicap (or violates any state or local law prohibiting discrimination on the basis of these or other characteristics);</li>
                    <li>That violates federal, state, or local equal employment opportunity laws, including but not limited to, stating in any advertisement for employment a preference or requirement based on race, color, religion, sex, national origin, age, or disability;</li>
                    <li>With respect to employers that employ four or more employees, that violates the anti-discrimination provision of the Immigration and Nationality Act, including requiring Nigeria citizenship or lawful permanent residency (green card status) as a condition for employment unless otherwise required in order to comply with law, regulation, executive order, or federal, state, or local government contract;</li>
                    <li>That impersonates any person or entity, including, but not limited to, an atPay employee, or falsely states or otherwise misrepresents your affiliation with a person or entity (this provision does not apply to Content that constitutes lawful non-deceptive parody of public figures);</li>
                    <li>That includes personal or identifying information about another person without that person's explicit consent;</li>
                    <li>That is false, deceptive, misleading, deceitful, misinformative, or constitutes "bait and switch";</li>
                    <li>That infringes any patent, trademark, trade secret, copyright, or other proprietary rights of any party, or Content that you do not have a right to make available under any law or under contractual or fiduciary relationships;</li>
                    <li>That constitutes or contains "affiliate marketing," "link referral code," "junk mail," "spam," "chain letters," "pyramid schemes," or unsolicited commercial advertisement;</li>
                    <li>That constitutes or contains any form of advertising or solicitation if: posted in areas of the atPay sites which are not designated for such purposes; or emailed to atPay users who have not indicated in writing that it is okay to contact them about other services, products, or commercial interests;</li>
                    <li>That includes links to commercial services or websites, except as allowed in "services";</li>
                    <li>That advertises any illegal service or the sale of any items the sale of which is prohibited or restricted by any applicable law;</li>
                    <li>That contains software viruses or any other computer code, files, or programs designed to interrupt, destroy, or limit the functionality of any computer software or hardware or telecommunications equipment;</li>
                    <li>That disrupts the normal flow of dialogue with an excessive amount of Content (flooding attack) to the Service, or that otherwise negatively affects other users' ability to use the Service;</li>
                    <li>That employs misleading email addresses, or forged headers, or otherwise manipulated identifiers in order to disguise the origin of Content transmitted through the Service;</li>
                    <li><strong>Refund Policy:</strong> User further understands that refund of any installment payments made funding wallet is refundable less an amount equal to 25% of the total installment sum already paid, including the initial deposit. Also, it will take a month before the refundable process is completed.</li>
                </ul>

                <h3 class="subsection-title">4. No Spam Policy</h3>
                <p>You understand and agree that sending unsolicited email advertisements to atPay email addresses or through atPay computer systems, which is expressly prohibited by these Terms, will use or cause to be used servers located in California. Any unauthorized use of atPay computer systems is a violation of these Terms and certain federal and state laws. Such violations may subject the sender and his or her agents to civil and criminal penalties.</p>
            </div>
        </div>
    </div>

    <?php include '../../../../include/app_settings.php'; ?>
    <footer style="text-align: center; font-size: 14px; color: var(--secondary-color); background-color: var(--primary-color); padding: 20px 0;">
        <?php echo APP_NAME_FOOTER; ?>
    </footer>
</body>
</html>