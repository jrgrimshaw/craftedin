<?php
class Mail {
    public function sendActivationEmail($toName, $toEmail, $code) {
        $m = new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth = true;
        $m->Host = '';
        $m->Username = '';
        $m->Password = '';
        $m->SMTPSecure = 'ssl';
        $m->Port = 465;
        $m->From = '';
        $m->FromName = '';
        $m->addAddress($toEmail, $toName);

        $m->isHTML(true);
        $m->Subject = 'Welcome to CraftedIn';
        $m->Body =
        '<div class="email-background" style="background-color: #eee;padding: 20px;">
            <div class="email-container" style="overflow: hidden;max-width: 500px;margin: 0 auto;background-color: #fff;border: 1px solid #ddd;border-bottom-width: 2px;border-radius: 3px;font-family: sans-serif;">
                <img src="' . APP_URL . 'static/images/external/email-header.jpg" class="email-logo" alt="CraftedIn Logo" style="width: 100%;">
                <div class="email-copy" style="padding: 0 20px;">
                    <p style="font-size: 15px;margin: 20px 0 0;line-height: 1.5;">Hi ' . $toName . ',</p>
                    <p style="font-size: 15px;margin: 20px 0 0;line-height: 1.5;">Welcome to CraftedIn. Before you get started, you are going to need to activate your account. To activate your account, simply click the button below.</p>
                </div>
                <div class="email-cta" style="padding: 20px;">
                    <a href="' . APP_URL . 'activate?email=' . $toEmail . '&code=' . $code . '" style="font-size: 15px;display: inline-block;padding: 10px 15px;background-color: #26ade4;border-radius: 3px;color: #fff;text-decoration: none;">Activate your account</a>
                </div>
            </div>
            <div class="footer" style="overflow: hidden;max-width: 500px;margin: 0 auto;margin-top: 10px;color: #999;font-size: 13px;font-family: sans-serif;">
                <p style="font-size: 12px;margin: 10px 0 0 0;line-height: 1.5;">&copy; ' . date("Y") . ' CraftedIn.</p>
                <p style="font-size: 12px;margin: 10px 0 0 0;line-height: 1.5;">We sent this email because you have an account at craftedin.co, and we needed to email you about an action relating to your account.</p>
            </div>
        </div>';
        $m->AltBody = 'Hi ' . $toName . '. Welcome to CraftedIn. Before you get started, you are going to need to activate your account. To activate your account, simply click or copy and paste the link into your browser. ' . APP_URL . 'activate?email=' . $toEmail . '&code=' . $code;

        if($m->send()) {
            return true;
        }
    }

    public function sendResetEmail($toName, $toEmail, $code) {
        $m = new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth = true;
        $m->Host = '';
        $m->Username = '';
        $m->Password = '';
        $m->SMTPSecure = 'ssl';
        $m->Port = 465;
        $m->From = '';
        $m->FromName = '';
        $m->addAddress($toEmail, $toName);

        $m->isHTML(true);
        $m->Subject = 'Reset Password Request';
        $m->Body =
        '<div class="email-background" style="background-color: #eee;padding: 20px;">
            <div class="email-container" style="overflow: hidden;max-width: 500px;margin: 0 auto;background-color: #fff;border: 1px solid #ddd;border-bottom-width: 2px;border-radius: 3px;font-family: sans-serif;">
                <img src="' . APP_URL . 'static/images/external/email-header.jpg" class="email-logo" alt="CraftedIn Logo" style="width: 100%;">
                <div class="email-copy" style="padding: 0 20px;">
                    <p style="font-size: 15px;margin: 20px 0 0;line-height: 1.5;">Hi ' . $toName . ',</p>
                    <p style="font-size: 15px;margin: 20px 0 0;line-height: 1.5;">To reset your password on CraftedIn, simply click the button below. If you didn\'t request a password reset, please <a href="' . APP_URL . 'support">contact us immediately</a>.</p>
                </div>
                <div class="email-cta" style="padding: 20px;">
                    <a href="' . APP_URL . 'reset-password?email=' . $toEmail . '&code=' . $code . '" style="font-size: 15px;display: inline-block;padding: 10px 15px;background-color: #56c959;border-radius: 3px;color: #fff;text-decoration: none;">Reset Password</a>
                </div>
            </div>
            <div class="footer" style="overflow: hidden;max-width: 500px;margin: 0 auto;margin-top: 10px;color: #999;font-size: 13px;font-family: sans-serif;">
                <p style="font-size: 12px;margin: 10px 0 0 0;line-height: 1.5;">&copy; ' . date("Y") . ' CraftedIn.</p>
                <p style="font-size: 12px;margin: 10px 0 0 0;line-height: 1.5;">We sent this email because you have an account at craftedin.co, and we needed to email you about an action relating to your account.</p>
            </div>
        </div>';
        $m->AltBody = 'Hi ' . $toName . '. To reset your password on CraftedIn, simply click or copy and paste the following link into your browser. If you didn\'t request a password reset, please <a href="' . APP_URL . 'support">contact us immediately</a>. ' . APP_URL . 'reset-password?email=' . $toEmail . '&code=' . $code;

        if($m->send()) {
            return true;
        }
    }
}