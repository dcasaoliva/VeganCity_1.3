-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-06-2016 a las 12:21:42
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `vegancity`
--

--
-- Volcado de datos para la tabla `vc_postmeta`
--

INSERT INTO `vc_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(63, 15, '_form', '<p class="text-petit">The fields market with an asterisk (*) are required.</p>\n\n<p><span class="main_text">1. Name</span> (*)<br />\n    [text* NAME] </p>\n\n<p ><span class="main_text">2. Where is placed:</span> a) Mark it on the map (*)<br />\n[map* COORD zoom:13] </p>\n\n<p><span class="main_text">2. Where is placed:</span> b) Enter the exact address</p>\n<p>Street:(*) [text* STREET]</p>\n<p class="enlinia num">Number:(*) [number* SNUMBER min:0 max:999]</p>\n\n<p><span class="main_text">3. Upload a photo: (*)(max. file size 1MB / min. width 800px)</span><br/>\n[file file-field limit:1000000]\n</p> \n\n<p><span class="main_text">4. Phone number(*)</span><br/>[tel* PHONE]</p>\n\n<p><span class="main_text">5. E-mail</span> <br />\n    [email EMAIL] </p>\n\n<p><span class="main_text">6. Internet:</span><br/>\nWeb / blog: [url URL]\n<span class="grup_alinea">Facebook:  </span> [url FACEBOOK]\n<span class="grup_alinea2">Twitter: </span>   [url TWITTER]\n<span class="grup_alinea3">Other: </span>     [url OTHERSM]</span></br>\n\n\n<p><span class="main_text">7. Category:</span> (*)(Check at least one) <br />\n\n  <span class="grup_ambits">  [checkbox* CATEGORIES use_label_element "Restaurant" "Market" "Clothes shop" "Activism"  ]</span></p>\n\n<p></p>\n\n<p>[submit]\n</p>'),
(64, 15, '_mail', 'a:8:{s:7:"subject";s:26:"VeganCity: New PLACE added";s:6:"sender";s:36:"VeganCity <noreply@vegancity.esy.es>";s:4:"body";s:175:"From: noreply@vegancity.esy.es\nSubject: VeganCity: New PLACE added\n\n\nNew PLACE added\n\n--\nThis e-mail was sent from a contact form on Vegan City (http://localhost/wordpress_vc)";s:9:"recipient";s:22:"vegancityweb@gmail.com";s:18:"additional_headers";s:0:"";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
(65, 15, '_mail_2', 'a:9:{s:6:"active";b:0;s:7:"subject";s:27:"Vegan City "[your-subject]"";s:6:"sender";s:31:"Vegan City <bfreixes@gmail.com>";s:4:"body";s:119:"Message Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on Vegan City (http://localhost/wordpress_vc)";s:9:"recipient";s:12:"[your-email]";s:18:"additional_headers";s:28:"Reply-To: bfreixes@gmail.com";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
(66, 15, '_messages', 'a:23:{s:12:"mail_sent_ok";s:45:"Thank you for your message. It has been sent.";s:12:"mail_sent_ng";s:71:"There was an error trying to send your message. Please try again later.";s:16:"validation_error";s:61:"One or more fields have an error. Please check and try again.";s:4:"spam";s:71:"There was an error trying to send your message. Please try again later.";s:12:"accept_terms";s:69:"You must accept the terms and conditions before sending your message.";s:16:"invalid_required";s:22:"The field is required.";s:16:"invalid_too_long";s:22:"The field is too long.";s:17:"invalid_too_short";s:23:"The field is too short.";s:12:"invalid_date";s:29:"The date format is incorrect.";s:14:"date_too_early";s:44:"The date is before the earliest one allowed.";s:13:"date_too_late";s:41:"The date is after the latest one allowed.";s:13:"upload_failed";s:46:"There was an unknown error uploading the file.";s:24:"upload_file_type_invalid";s:49:"You are not allowed to upload files of this type.";s:21:"upload_file_too_large";s:20:"The file is too big.";s:23:"upload_failed_php_error";s:38:"There was an error uploading the file.";s:14:"invalid_number";s:29:"The number format is invalid.";s:16:"number_too_small";s:47:"The number is smaller than the minimum allowed.";s:16:"number_too_large";s:46:"The number is larger than the maximum allowed.";s:23:"quiz_answer_not_correct";s:36:"The answer to the quiz is incorrect.";s:17:"captcha_not_match";s:31:"Your entered code is incorrect.";s:13:"invalid_email";s:38:"The e-mail address entered is invalid.";s:11:"invalid_url";s:19:"The URL is invalid.";s:11:"invalid_tel";s:32:"The telephone number is invalid.";}'),
(67, 15, '_additional_settings', 'demo_mode: on'),
(68, 15, '_locale', 'en_US'),
(76, 22, '_form', '<div id="wrap_rates">\n<p class="main_text">Best<br />\n    [text* r_best maxlength:70] </p>\n\n\n<p class="main_text">Not best<br />\n    [text* r_notbest maxlength:70] </p>\n\n[checkbox* r_rating exclusive "1" "2" "3" "4" "5"]\n\n[dynamichidden r_postid "CF7_get_post_var key=''ID''"]\n\n<p>[submit "Rate Place"]</p>\n</div>'),
(77, 22, '_mail', 'a:8:{s:7:"subject";s:25:"VeganCity: New RATE added";s:6:"sender";s:36:"VeganCity <noreply@vegancity.esy.es>";s:4:"body";s:172:"From: noreply@vegancity.esy.es\nSubject: VeganCity: New RATE added\n\nNew RATE added\n\n--\nThis e-mail was sent from a contact form on Vegan City (http://localhost/wordpress_vc)";s:9:"recipient";s:22:"vegancityweb@gmail.com";s:18:"additional_headers";s:0:"";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
(78, 22, '_mail_2', 'a:9:{s:6:"active";b:0;s:7:"subject";s:27:"Vegan City "[your-subject]"";s:6:"sender";s:31:"Vegan City <bfreixes@gmail.com>";s:4:"body";s:119:"Message Body:\n[your-message]\n\n--\nThis e-mail was sent from a contact form on Vegan City (http://localhost/wordpress_vc)";s:9:"recipient";s:12:"[your-email]";s:18:"additional_headers";s:28:"Reply-To: bfreixes@gmail.com";s:11:"attachments";s:0:"";s:8:"use_html";b:0;s:13:"exclude_blank";b:0;}'),
(79, 22, '_messages', 'a:23:{s:12:"mail_sent_ok";s:45:"Thank you for your message. It has been sent.";s:12:"mail_sent_ng";s:71:"There was an error trying to send your message. Please try again later.";s:16:"validation_error";s:61:"One or more fields have an error. Please check and try again.";s:4:"spam";s:71:"There was an error trying to send your message. Please try again later.";s:12:"accept_terms";s:69:"You must accept the terms and conditions before sending your message.";s:16:"invalid_required";s:22:"The field is required.";s:16:"invalid_too_long";s:22:"The field is too long.";s:17:"invalid_too_short";s:23:"The field is too short.";s:12:"invalid_date";s:29:"The date format is incorrect.";s:14:"date_too_early";s:44:"The date is before the earliest one allowed.";s:13:"date_too_late";s:41:"The date is after the latest one allowed.";s:13:"upload_failed";s:46:"There was an unknown error uploading the file.";s:24:"upload_file_type_invalid";s:49:"You are not allowed to upload files of this type.";s:21:"upload_file_too_large";s:20:"The file is too big.";s:23:"upload_failed_php_error";s:38:"There was an error uploading the file.";s:14:"invalid_number";s:29:"The number format is invalid.";s:16:"number_too_small";s:47:"The number is smaller than the minimum allowed.";s:16:"number_too_large";s:46:"The number is larger than the maximum allowed.";s:23:"quiz_answer_not_correct";s:36:"The answer to the quiz is incorrect.";s:17:"captcha_not_match";s:31:"Your entered code is incorrect.";s:13:"invalid_email";s:38:"The e-mail address entered is invalid.";s:11:"invalid_url";s:19:"The URL is invalid.";s:11:"invalid_tel";s:32:"The telephone number is invalid.";}'),
(80, 22, '_additional_settings', 'demo_mode: on\non_sent_ok: "document.getElementById(''wrap_rates'').style.display = ''none'';"'),
(81, 22, '_locale', 'en_US');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
