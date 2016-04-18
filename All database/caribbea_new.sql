-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2016 at 06:36 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `caribbea_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `country` varchar(150) NOT NULL,
  `aname` varchar(100) NOT NULL,
  `towork` varchar(200) NOT NULL,
  `genre` varchar(200) NOT NULL,
  `query_sub` varchar(200) NOT NULL,
  `query` text NOT NULL,
  `file1` varchar(255) NOT NULL,
  `file2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_login`
--

CREATE TABLE IF NOT EXISTS `tbl_admin_login` (
`id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin_login`
--

INSERT INTO `tbl_admin_login` (`id`, `name`, `password`) VALUES
(1, 'siTmaG', 'DisMadeR2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chat`
--

CREATE TABLE IF NOT EXISTS `tbl_chat` (
`id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `msg` text NOT NULL,
  `msg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_status` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_chat`
--

INSERT INTO `tbl_chat` (`id`, `from_id`, `to_id`, `msg`, `msg_time`, `view_status`) VALUES
(1, 0, 0, '', '2014-01-16 13:39:45', 1),
(2, 0, 0, '', '2014-07-19 02:42:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms`
--

CREATE TABLE IF NOT EXISTS `tbl_cms` (
`id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `heading` varchar(60) NOT NULL,
  `cms_text` text NOT NULL,
  `meta_keyword` varchar(60) NOT NULL,
  `meta_description` varchar(60) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_cms`
--

INSERT INTO `tbl_cms` (`id`, `name`, `heading`, `cms_text`, `meta_keyword`, `meta_description`, `status`) VALUES
(1, 'Home', 'CARIBBEAN CIRCLE STARS', '<p>Welcome to Caribbean Circle Stars, your one stop to networking in your area. CCS is created with the people in mind.&nbsp; It is formulated to bring the people of the Caribbean together into one place, where they can showcase their talents.&nbsp; Communicate with people in your field of works and arts. Share knowledge of each other communities, growth and problems.&nbsp; Use CCS for networking and solving problems and issues facing you and your communities in different aspects of your daily lives.&nbsp; Have open Forums on topics and issues, and suggestions on how to solve the problems you face. &nbsp;All Caribbean and Caricom countries residents are free to join this website, and showcase their talents, works and arts.</p>\r\n\r\n<p>All Musicians, Dancers, Historians, Religious educators, Authors, Crafters, Artist, &nbsp;Actor, Actresses, Models, Athletes, Sports, Performers and Comedians, are welcome to join.&nbsp; CCS website is open to fans, patrons, and clients, who would like to sign up and enter our network as well.&nbsp; Please read the <a href="terms-of-use.php">Terms of Service</a>,to know more about the usage of CCS website.</p>\r\n\r\n<p>Professionals and unprofessionals acts and talents have the same rights and privileges on this website.&nbsp; CCS website is created with intent to bring about exposure to the all hidden and known talent in the Caribbean and Caricom countries.&nbsp; We are, <em>therefore</em>, anxious and please to hear and see all what you have to offer the Caribbean and Caricom countries and the world at large.&nbsp; We here at CCS encourage ordinary people to join our network, meet new people and network with friends.&nbsp; Our motto is <em><strong>&#39; little people moving mountains&#39;</strong></em>,<em> all we people come</em>!&nbsp; We would like to develop a wonderful business relationship with all our interested participants of this website.&nbsp; Therefore, we advise that all interested users, please read what is required by our administration, before signing up with CCS.</p>\r\n\r\n<p>We are open for feedback and suggestions, that will help us build a better us and a bigger you.&nbsp; We the management of CCS would like to say a special thank you, for your support and joining our website.&nbsp; Have a wonderful experience and invite a friend.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><em><big>By the management of CCS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</big></em><em><big>&nbsp; </big></em></p>\r\n\r\n<p><em>Copyright 2013&copy;</em></p>\r\n', '', '', 1),
(2, 'About', 'About', '<p>Caribbean Circle Stars was founded in February 2013.CCS is set up for your entertainment and family networking in the Caribbean. Our goal at Caribbean Circle Stars, is to provide a network that will fairly meet the needs of the online Caribbean community. Our website will enables patrons and users to profile themselves, their works and talent. Our goal is to connect, inform, and educate people about our beautiful Caribbean culture. Our users will have the opportunity enjoy a great online community, message forums, news, instant messaging and browse our talented users works. CCS is committed to making communication available and easier for people of Caribbean, so, our users can establish relationships, gain access to important information, show their national pride, and participate in community activities together. Our website provide end-users with a dynamic medium through which instant communication and networking can occur. Our website main purpose is to bring our countries together and allow you to educate, share and express your thoughts and opinions and grow as a region.<br />\r\n<br />\r\nCCS website is set up to provide our users with opportunities to market their products more effectively to both the Caribbean and the international market. &nbsp;Our website is equipped with a shopping cart to accommodate users, who would like to sell their works and arts. Whether your interests is in arts, entertainment, literature, religion or history, you will find &nbsp;our shopping cart quite a convenience and suitable for your needs. Our users can promote your works, talents and arts on our site through advertising, to help maximize your presence and attract an impressive audience. Contact us about the fees or budgets for your projects, each project will be reviewed. We would like to promote our Caribbean music and strengthen it&#39;s impact on our fellow Caribbean citizens and the international music scene. &nbsp; We are open to promote all music, but, our main focus is music of the Caribbean. CCS is focus to bring the attention of international patrons and the public interest towards the Caribbean as one of the world&rsquo;s most talented region.<br />\r\n<br />\r\nWe are accepting submissions of songs and music in mp3 format for our music player. All song will be screened to see if it meets our criteria. Please follow instructions on how to submit your music. Give a brief information about your music when submitting it, and you must be the owner of the music you submit.<br />\r\n<br />\r\nWe at CCS welcome business contacts seeking advertising, promotions, publicity, whether, it is for business or personal needs.<br />\r\n<br />\r\nFor further questions and queries please email us at: admin@caribbeancirclestars.com.<br />\r\n<br />\r\nBy the management of CCS. &copy;2013 All rights reserved.</p>\r\n', '', '', 1),
(3, 'Spotlight', 'Spotlight', '<p><big><samp><ins><em><strong>WARRIOR KING</strong></em></ins></samp></big></p>\r\n\r\n<p><img src="http://caribbeancirclestars.com/_images/Profile_big_img.jpg" style="float:left; margin-right:17px" />Like a bolt of lightning from the sky, Warrior King burst upon the Reggae scene, utilizing his gift of song to spread Jah truth throughout the land. Warrior King was born on the 27th of July, 1979, in Kingston, Jamaica&rsquo;s Jubilee Hospital.</p>\r\n\r\n<p><em>&ldquo;From birth I&rsquo;ve always loved music, but it was not until I attended high school at the age of thirteen that I thought about it as something I could do myself,&rdquo;</em> Warrior King explains. <em>&ldquo;At that time I followed Bounty Killer&rsquo;s style, but then my friends said, &lsquo;You have the potential. You have the talent.&rsquo; From there I started increasing my own thing, and with encouragement from my peers the music started to flow. Music is a natural thing that just grow inside of me, even without me realizing,&rdquo; the singer reasons. </em><br />\r\n<br />\r\nWarrior King&rsquo;s 2001 debut single, &ldquo;Virtuous Woman,&rdquo; was an international smash, its righteous lyrics prompting the Jamaica Observer to declare the singer &ldquo;one of the artistes who made a difference in 2001.&rdquo; Since that auspicious beginning, Warrior King&rsquo;s compositions have consistently charted not only in his native Jamaica, but throughout the entire Caribbean, as well as New York, London, Tokyo and beyond. &ldquo;Stand Up inna di Fyah&rdquo; is currently getting heavy rotation in Jamaica.</p>\r\n\r\n<p>Now the conscious singer has released his third full-length album <em>&ldquo;Tell me how me Sound &ldquo;.</em> The CD&rsquo;s nineteen tracks are designed, says Warrior King, to &ldquo;<em>uplift people&rsquo;s heart, mind and soul in a positive way. All of the songs are written by me, through inspiration of the Father.&rdquo;</em> Each song featured on the CD has a different style, but the message emphasizes purity and truth.</p>\r\n\r\n<p>In 2007 Warrior King started an independent record label known as Rootz Warrior Productions.<br />\r\n<br />\r\nWarrior King believes that education is the key to betterment and hopes that his music will serve to convey the teachings of His Imperial Majesty, Haile Selassie I.</p>\r\n\r\n<p><em>&ldquo;As a Rastafarian, I must sing music with a purpose and a mission. To the four corners of the Earth, I carry my music, and the message of the King. His message is a message of love for people of all races. I am Jah warrior, fighting a war of rootical love straight from my heart.&rdquo;</em></p>\r\n\r\n<p><em>Selah</em><br />\r\n<br />\r\n<br />\r\n<img src="http://caribbeancirclestars.com/_images/rootz.jpg" /></p>\r\n\r\n<p>Contact Information: Warrior King</p>\r\n\r\n<p><strong>Rootz Warrior Productions</strong></p>\r\n\r\n<p>Phone: 876-479-1796 JA</p>\r\n\r\n<p>Phone: 347-709-4205 USA</p>\r\n\r\n<p>Email: <a href="mailto:rootzwarriormusic@gmail.com">rootzwarriormusic@gmail.com</a></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Hours of Operation</strong></p>\r\n\r\n<p>Mon-Fri: 10am-6pm</p>\r\n\r\n<p>Sat: Sabbatical Order</p>\r\n\r\n<p>Sun: 10am-2pm</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Mailing Address</strong></p>\r\n\r\n<p>133 Sundrive Johnson&#39;s Hill</p>\r\n\r\n<p>Hellshire P.O.&nbsp;St. Catherine</p>\r\n\r\n<p>Jamaica, West Indies</p>\r\n', '', '', 1),
(4, 'Donate', 'Donate', '', '', '', 1),
(5, 'Forum', 'The Stars of Today', '<p>Star of today is the hope of a brighter future.</p>\r\n', '', ' \r\n', 1),
(6, 'Contact', 'Contact', '', '', '', 1),
(7, 'Faq', 'Frequently Ask Questions', '<p><strong>Is registration free on CCS?</strong><br />\r\nYes registration is free on CCS.<br />\r\n<br />\r\n<strong>Are users from out of the Caribbean and Caricom countries allow to sign up for the talent section?</strong><br />\r\nNo, the website is only present open to talents from the Caribbean and Caricom countries at this time.<br />\r\n<br />\r\n<strong>What age are allow for talents?</strong><br />\r\nAny age from 13 years and over can sign to be on the talent section. However, those under 18 years must have their&nbsp;parent or guardian to transact any business on their behalf.<br />\r\n<br />\r\n<strong>Are all talents welcome on CCS?</strong><br />\r\nYes we are open to all talents, professional and unprofessional.<br />\r\n<br />\r\n<strong>Do we have to provide our true names for the talent section?</strong><br />\r\nYes you need to sign up with you legal name, as well as you performance name at registration.<br />\r\n<br />\r\n<strong>Why do we have to give our legal name?</strong><br />\r\nTo allow you to do business transactions, you must provide true identification to sell on this site.<br />\r\n<br />\r\n<strong>What happens to people who give false information?</strong><br />\r\nTheir account on CCS website will be suspended, until fully investigated. After the investigation we will decide if the account should be reopened.<br />\r\n<br />\r\n<strong>Can a manager or company open an account on your behalf?</strong><br />\r\nNo, all talents must be done by the individual themselves.<br />\r\n<br />\r\n<strong>Do you share our information with company&#39;s or other users?</strong><br />\r\nNo your information is kept private and is only use to identify you from other users.<br />\r\n<br />\r\n<strong>Are we responsible for safe guarding our login and other sign information?</strong><br />\r\nYes, please don&#39;t share your information with other users or non-users of this website.<br />\r\n<br />\r\n<strong>Why, is there a problem sharing our private information?</strong><br />\r\nThis is a talent as well as a business website, and someone can transact business that you do not like or consulted.This will cause you to loose the account if it is in violation of our rules on CCS. And you will be liable for all expenses made on your account, if there is any.<br />\r\n<br />\r\n<strong>Does CCS take a service fee for selling done on this website?</strong><br />\r\nYes, we take 25% on any sale done.<br />\r\n<br />\r\n<strong>Are the fees refundable?</strong><br />\r\nFees and money paid to the website is non-refundable.<br />\r\n<br />\r\n<strong>What if a customer returned the goods?</strong><br />\r\nCCS will make the exception on fees that is more than $1.00 per a given sale. The item must be returned and the certify slip presented to us.<br />\r\n<br />\r\n<strong>Do you accept Donations?</strong><br />\r\nYes thank you, we do appreciate monetary contributions to our website.<br />\r\n<br />\r\n<strong>Are we allowed to post flyers on our profile pages?</strong><br />\r\nYes, you can post flyer for your events on your profile page.<br />\r\n<br />\r\n<strong>Are we allowed to post events on another user page?</strong><br />\r\nNo, all user must post their events on their own profiles.<br />\r\n<br />\r\n<strong>Do you accept music for the player?</strong><br />\r\nYes, you can submit music for review. We will let you know if it is accepted.<br />\r\n<br />\r\n<strong>Do we pay to have our music promoted on the music player?</strong><br />\r\nNo, music selected for the music player will be free of charge.<br />\r\n<br />\r\n<strong>Do you promote our profiles or work on your homepage?</strong><br />\r\nYes, you can have your work promoted on the homepage for a fee, that will be decided upon according to the work involved.</p>\r\n', '', '', 1),
(8, 'Privacypolicy', 'Privacy policy', '<p><strong>Introduction to our policy:</strong><br />\r\n<br />\r\n&#8203;The information that is displayed on our website should not be used for any purpose that is unlawful or prohibited by the terms, conditions and policies of <strong>Caribbean Circle Stars</strong>. &nbsp;CCS contents should not be modified, published, transmitted, sold, or reproduced by second and third party users, guests, patrons or clients without management consent. &nbsp;Our website contains facts, views, opinions regarding our services and products, but, at the same time we don&#39;t represent or endorse the accuracy regarding the results obtained from the use of our information. <strong>Caribbean Circle Stars</strong> (CCS), shall not be liable for any consequential, incidental damage or loss of profits or royalties arising out of any services provided by us, or, all users of this website. &nbsp;Nothing shall be considered as a substitute of personal investigation and the sound technical and business judgment of the reader. The patrons, clients and users should, therefore, periodically <strong>check for updates</strong> in CCS<em><strong> <ins>Terms of Services</ins></strong></em> (TOS), when you visit our website. &nbsp;Changes will be posted to the website and users agree to be bound by our TOS. &nbsp;We caution all customers and website users/visitors that no medium of communication, including the Internet is entirely secure.<br />\r\n<em><ins><strong>CCS is a free website</strong></ins></em>, all sign up information must be truthful and accurate. The registration and sign up for using this service is free don&#39;t worry, you do not need to pay a monthly or yearly fee. &nbsp;Anyone, found giving false or misleading information to access the website will be persecuted accordingly. &nbsp;CCS <strong><em>must not be use for any terrorist activities</em></strong> by users of our website. &nbsp;No spamming or trying to invade/hack other users account. &nbsp;<strong>This website is design with the family in mind, man, woman and child. &nbsp;<em>Ages from 13 years to 100 years are allowed on this site</em></strong>. Teenagers are allowed on CCS, so, they can display their talents, arts/gifts to society. &nbsp;Therefore, read and follow the rules strictly, so, as not to violate the rights of these younger ones using the CCS website. &nbsp;<em><ins>Remember, this website is created for the education of our culture, and having a decent communication within our societies</ins>.</em><br />\r\n<br />\r\nCCS <strong><em>is divided</em></strong> into <strong><em>two</em></strong> sections:-<br />\r\n<br />\r\n<strong>Section A</strong> - is for<strong> fans, patrons, and clients.</strong><br />\r\n<br />\r\n<strong>Section B</strong> - is<ins><strong><em> for Caribbean &amp; Caricom citizens</em></strong></ins>, or, first descendants of Caribbean citizens living outside the Caribbean (meaning you are born outside of the Caribbean, but, your parents (mother and father or either one of them is from the Caribbean). Second and third descendants born overseas must be living in the Caribbean to be apply for <strong><em>Section B. &nbsp;Anyone, knowing of persons giving false information or misrepresenting identification to access the benefits of CCS. Please contact the management of CCS, your identity will not be disclose in the matter. The perpetrator will be investigated and remove from the website</em></strong>.<br />\r\n<br />\r\n<strong>Section B</strong> - is created to help expose our talents and arts in different forms. &nbsp;Musicians, Dance, History, Religion, Authors, Crafts &amp; Arts, Actors and Actresses, Athletes, Models, Performers and Comedians.<strong>Section B </strong>is open to both skilled and unskilled. Professionals and the unprofessional.&nbsp;<br />\r\n<br />\r\n<strong>Warning - Users of our website must not impersonate CCS or its&rsquo; administration, employees and moderators &nbsp;of our website. All interested users must at all time provide true information to quality for this service. Management of CCS reserves the right to check identification at any given time. Each individual user must open their own account, no managers or companies are allowed to open an account on your behalf. Persons found giving false information will be remove from this site. Anyone whose account is remove/deactivate cannot re-apply to CCS website or any of our internet business sites again.</strong><br />\r\n<br />\r\n<strong>Privacy Policy:&nbsp;</strong><br />\r\nCCS do not share any personal information submitted by our clients and patrons to any second or third party participants. Patrons, clients and all users of CCS are, therefore, responsible for the way they disclose their information to other patrons, users or clients on this website. We own the sole right to discontinue any services rendered to you or deny the access of any user, patron or client, if he or she fails to comply with the rules implemented by CCS. Website contents, projects or events, and the mentioned offers / prices are subjected to changes from time to time, without any prior notice and the management decision regarding any kinds of dispute, if any, will be abiding. By accessing CCS website, all users, patrons and clients agrees to abide by all the copyright notices and restrictions attached to any and all contents including our rules.&nbsp;<br />\r\n<br />\r\n<strong>Information collection and sharing:</strong>&nbsp;<br />\r\nCCS recognize your rights to confidentiality and we are devoted to protecting your privacy. We are the sole owner of the information collected by this website and we do not rent, sell or loan any information collected by the website to others unless legally required. It is necessary to protect the legitimate interests of our customers and us. It is required to cooperate with interception orders, warrants, or other legal process that we determines in our sole discretion to be valid and enforceable. CCS will store your information for identity purpose, so, we can know who is on our website. CCS can get a better view of our website effects and progress according to our services, we derive from your information. CCS needs to know, how to design our products and services to suit your needs. If you correspond with us via E- mail, we may collect the information and store it with full confidentiality. It may, also, be used to provide you with information concerning our industry news, special events or features and offers suited for you. We disclaim any intention to censor, edit -our website by customers or others. &nbsp;We will, however, review, delete or block access to communications that may harm customers, or third parties or us. The grounds on which we may take such action include, but are not limited to, actual or potential violations of our Acceptable Use Policy.<br />\r\n<br />\r\n<strong>Passwords and Login information:</strong><br />\r\n<br />\r\nAll registered users of CCS are responsible for keeping your login information in a secure manner. Allowing someone to sign into your account can result in you loosing your account. As, you would not know what a person can transact or project under your identification. Whatever, transpires under your name and through your account is your sole responsibility, and you will not be given pardon. User are not allowed to choose usernames, that is obscene, indecent, abusive or which might otherwise subject this website to public disparagement or scorn. All registered users must give your hometown and Country, when signing up (this &nbsp;information can be disclose on your public profile if you wish, you can disclose where you live at your sole discretion only). CCS reserve the right, without prior notice to you, to automatically change your username.<br />\r\n<br />\r\n<strong>Modifications:&nbsp;</strong><br />\r\nAll customers, patrons, clients and users may access and modify their personal information via their online personal account information page. Please make sure that all your information stays current and up to date. CCS does not allow users to sell or transfer your account to anyone,if you no longer need the use of CCS services your account will be closed. There should be no impersonation or falsification of identification, your identification should be corresponding to that which is proclaim as your legal name. Please be precise and factual at all times.<br />\r\n<br />\r\n<strong>Spams/Phishing:</strong>&nbsp;<br />\r\nCCS will not tolerate the transmission of spams from our website. Customers caught using this website for this purpose of sending spams are fully investigated. Once CCS determines there is a problem with spam, we will take the appropriate action to resolve the situation. Users attempting to acquire information such as usernames, passwords, and credit card details, will be immediately remove from our website. User are not allowed to transmit, bots worms, computer codes, &lsquo;junk mail&rsquo;,&ldquo;chain letters&rdquo;, &ldquo;unsolicited mass mailing&rdquo; and instant messaging. Do not alter or try to modify someone else profile without their permission. Do not stalk, harass, restrict or inhibit any other user from enjoying their forums.&nbsp;<br />\r\n<br />\r\n<strong>Language:</strong><br />\r\nCCS will not permit <strong>any verbal abuse on this website</strong>. No Atheist or Religious hate comments allowed on this website. As a customer using CCS, we advise you use the groups and interests that best suits you and your likings, that would not cause you any upset.To avoid being remove from this website. No cursing and swearing e.g. sexually &quot;F&quot; words or mother connect as a prefix, no sluts, hoes or whores, no heifer or cocks, no bitch/bitches, prostitute, no asses, cu*t, ni*g*r. Period! &nbsp;They must not appear in your works either, please edit your materials, before, posting them on this website. I will add more insult words as the issues arise. A customer may get one warning or chance only, before, your account is deactivated. Some incidents may not be given any pardons. It depends on the issue and problem that arise. &nbsp;All users agrees that you will not defame, abuse, harass, stalk, threaten or otherwise violate the legal right of other users on this website. Our management and staff reserves the right to delete your posts from Forums/bulletin boards.<br />\r\n<br />\r\n<strong>Sales Policy:</strong>&nbsp;<br />\r\nOur Customers are allowed to sell their materials, Photos, Books, Audios, Videos, you must owned the full rights to it. Unless, you can prove by law that you have been given rights by a owner/owners to sell work, produce by them on their behalf, or a joint project.<strong> Caribbean Circle Stars has hereby entered into an agreement with you the users of this website program, on this sales usage agreement that it must be carried out as required by us. CCS requires 25% of all sales transacted through this website, which must be paid at the time of the said sale/sales. Any user of our service found not in compliance with the rule will have your account deactivated /removed.</strong><br />\r\n&nbsp;CCS only allows the customers and users of Section B on this website to sell their Arts/Works through our website. No counterfeit or illegal goods are allowed to be uploaded and sole through this website, or such transactions transpired. Anyone, caught doing such will be penalize according to the law, the penalty is maximum. CCS will not be responsible for any goods/services sold or promise to your customers. As a users of CCS services, you hereby legally agree to be honest and open to your clients in any and all your business transactions and ventures. All CCS users in their different forms of,&#39;Arts and Works&#39; must make their terms of sales/delivery openly known in advance with their customers. Please make clear your terms of return policies as regarding your goods and services.&nbsp;<br />\r\nNote: All underage acts/talents below the age of 21 years, need a guardian to sign up a sales account and shopping cart on your behalf. Anyone, found doing sales and does not meet the age criteria will have your account suspended.</p>\r\n\r\n<p><strong>Promotion and Advertising:</strong><br />\r\nNo banners are allowed on this website from all users. All our users, fans, patrons, talents and arts form can post events, invitations and promotions on their profiles only. CCS does not allow our users to involve in any commercial activities and/ or sales without prior written consent from CCS administration in regards, to such as, sweepstakes, contests, advertising, banners. Users are not allowed to post your events, invitations and promotions on the profiles of other users on our website. Persons caught doing this will be given one warning, the second incident will cause your account to be remove/deactivated. Voting, competing and charting is not allowed on CCS website. Clients who are business owners or work in the commercial industry must only post advertisement through the approval from management of CCS (contact the CCS Administration). No forms of advertising should be altered after posted on or submitted to CCS, from a remote location. All individuals posting or presenting/submitting different forms of advertisement is &#39;hereby&#39; responsible and takes full penalty for any damage cause to our website, if found guilty of viral infections cause by your advertisements. Individuals, users and clients found causing damage will pay the full cost of repairs to the website.<br />\r\n<br />\r\n<strong>Materials, Photos, Data, Files, Audios and videos, Books, Literatures:</strong><br />\r\nCCS and staff does not take responsibility for materials posted or uploaded by our customers on this website. It is your responsibility to keep back up files, however, you store them on your computers of all your data, files, audios, photos and materials you upload to this website. Please make sure that all your materials/works are Copyrighted and that you are the owner and have rights to publish or post them on CCS website. Check with your government registrar and other offices according to your Country laws, about, Trademarks, Logos, Copyrights or Licensed for your Arts/Works. Do not upload files that contain viruses, corrupted files, or any other similar software or programs that may cause damage to our website, or, another person computer. This privilege is presented to the customers of CCS &quot;as is&quot; and is available for your use according to your discretion. &nbsp;Customers found misusing this privilege to steal, deface/devalue or exploit anyone work/art, will be remove from being a member and customer of CCS. Please, consult with each owner about their work and your allowed privilege and usage of their work, arts or materials. &nbsp;No child pornography, trafficking in obscene material, frauds, pyramid schemes, drug dealing and gambling are allowed. There must be no soliciting of sex buying or selling on this website. CCS reserves the right to investigate and take appropriate action (which may include taking legal action) against anyone who, in CCS sole discretion, violates this provision, including, without limitation, removing the offending Content from the CCS website, terminating the Membership of such violators and/ or reporting such Content or activities to law enforcement authorities.<br />\r\n<br />\r\n<strong>&nbsp;Warning!<br />\r\nNo explicit materials, audios, arts/portraits, Michael Angelo/nude sculptures, R rated comedians- language , videos, photos, files should be published on this website period! Photos or videos of men clothed in shorts/trousers, but, topless allowed, no jockeys/ undies allowed. Women must have on a top and bottom piece at all times &nbsp;(very decent and appropriate).Bath suits and decent under wear permitted.<br />\r\n<br />\r\nAgreement on Good or Service uploaded on CCS website:</strong><br />\r\nAll patrons/fans, users and clients &#39;hereby&#39; agrees to indemnify, defend and hold the Service, and all our management, directors, owners, agents, information provided, affiliates and licensors(collectively the &quot;Parties&quot;) harmless from and against any and all liability, losses, costs and expenses (including attorney&#39;s fee) incurred by any Party in connection with any claim arising out of the following:-<br />\r\nAny use or alleged use of your account or password by any person, whether or not authorized by you. Any claim arising out of the materials that you upload on CCS website. Including, but, not limited to, claims for defamation, violation of rights of publicity and/or privacy, copyright infringement, trademark infringement and any claim or liability relating to the content, quality, or performance of materials/ works that you upload to the website. We reserve the right, at our expense, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, and in such case, you agree to cooperate with our defense of such claim. The listing, of any document in our service search database does not imply any warranty or guarantee by us, for any companies, products, or services describe in such documents. We disclaim any and all responsibility or liability for the accuracy, content, completeness, legality, reliability, or operability or availability of information or material displayed in CCS search results. We disclaim any responsibility for the deletion, failure to store, misdelivery, or untimely delivery of any information or material/work. We disclaim any responsibility for any harm resulting from downloading or accessing any information or material/ work on the world Wide Web or Internet using search results from our Service.<br />\r\n<br />\r\nWE DO NOT WARRANT THAT THE SERVICE WILL BE UNINTERRUPTED OR ERROR-FREE. IN ADDITION, WE DO NOT MAKE ANY WARRANTY AS TO THE RESULTS TO BE OBTAINED FROM USE OF THE SERVICE OR CONTENT. THE SERVICE AND THE CONTENT ARE DISTRIBUTED ON AN &quot;AS IS&quot;, AS AVAILABLE&quot; &nbsp;BASIS. ANY MATERIAL DOWNLOADED OR OTHER WISE OBTAINED THROUGH THE SERVICE IS DONE AT YOUR OWN DISCRETION AND RISK, AND YOU WILL BE SOLELY RESPONSIBLE FOR POTENTIAL DAMAGES TO YOUR COMPUTER SYSTEM OR LOSS OF DATA THE RESULTS FROM THE DOWNLOAD OF ANY SUCH MATERIAL. WE DO NOT MAKE ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, WARRANTIES OF TITLE OR IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WITH RESPECT TO THE SERVICE, ANY CONTENT OR ANY PRODUCTS OR SERVICES SOLD THROUGH THE SERVICE. YOU EXPRESSLY AGREE THAT YOU WILL ASSUME THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE SERVICE AND THE ACCURACY OR COMPLETENESS OF ITS CONTENT. WE SHALL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OF OR INABILITY TO USE THE SERVICE, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. WE RESERVE THE RIGHT TO TERMINATE THE SERVICE AT ANY TIME WITH MINIMUM NOTICE OR WITHOUT NOTICE.&#8203;<strong> &nbsp;&nbsp;</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '', '', 1);
INSERT INTO `tbl_cms` (`id`, `name`, `heading`, `cms_text`, `meta_keyword`, `meta_description`, `status`) VALUES
(9, 'Termsofuse', 'Terms of use', '<p>Terms Of Service</p>\r\n\r\n<p><br />\r\nIntroduction to our policy:</p>\r\n\r\n<p>The information that is displayed on our website should not be used for any purpose that is unlawful or prohibited by the terms, conditions and policies of <em><strong>Caribbean Circle Stars</strong></em>.&nbsp; CCS contents should not be modified, published, transmitted, sold, or reproduced by second and third party users, guests, patrons or clients without management consent.&nbsp; Our website contains facts, views, opinions regarding our services and products, but, at the same time we don&#39;t represent or endorse the accuracy regarding the results obtained from the use of our information.&nbsp;<em><strong> Caribbean Circle Stars</strong></em> (CCS), shall not be liable for any consequential, incidental damage or loss of profits or royalties arising out of any services provided by us, or, all users of this website.&nbsp; Nothing shall be considered as a substitute of personal investigation and the sound technical and business judgment of the reader.&nbsp; The patrons, clients and users should, therefore, periodically<strong> check for updates</strong> in CCS <ins><strong><em>Terms of Services</em></strong></ins> (TOS), when you visit our website.&nbsp; Changes will be posted to the website and users agree to be bound by our TOS.&nbsp; We caution all customers and website users/visitors that no medium of communication, including the Internet is entirely secure.<br />\r\n<strong><em><ins>CCS is a free website</ins></em></strong>, all sign up information must be truthful and accurate.&nbsp; The registration and sign up for using this service is free, you do not need to pay a monthly or yearly fee.&nbsp; Anyone, found giving false or misleading information to access the website will be persecuted accordingly.&nbsp; CCS<strong><em> must not be use for any terrorist activities</em></strong> by users of our website.&nbsp; No spamming or trying to invade/hack other users account.&nbsp;<strong><ins> This website is design with the family in mind</ins></strong>, <strong>man, woman and child</strong>.&nbsp; <em><strong>Ages from 13 years to 100 years are allowed on this site</strong></em>.&nbsp; Teenagers are allowed on CCS, so, they can display their talents, arts/gifts to society.&nbsp; Therefore, read and follow the rules strictly, so, as not to violate the rights of these younger ones using the CCS website.&nbsp; <em><ins>Remember, this website is created for the education of our culture, and having a decent communication within our societies</ins></em>.</p>\r\n\r\n<p>CCS <strong><em>is divided</em></strong> into <em><strong>two</strong></em> sections:-<br />\r\n&nbsp;<br />\r\n<strong>Section A</strong> - is for <strong>fans, and patrons</strong>.<br />\r\n&nbsp;<br />\r\n<strong>Section B</strong> - <strong><em><ins>is only for Caribbean &amp; Caricom citizens</ins></em></strong>, <ins>or</ins>, first descendants of Caribbean citizens living outside the Caribbean (meaning you are born outside of the Caribbean, but, your parents (mother and father or either one of them is from the Caribbean).&nbsp; Second and third descendants born overseas must be living in the Caribbean to be apply for</p>\r\n\r\n<p><strong>Section B</strong>.<em>&nbsp;<ins> Anyone, knowing of persons giving false information or misrepresenting identification to access the benefits of CCS.&nbsp; Please contact the management of CCS, your identity will not be disclose in the matter.&nbsp; The perpetrator will be investigated and remove from the website</ins></em>.</p>\r\n\r\n<p><strong>Section B </strong>- is created to help expose our talents and arts in different forms.&nbsp; Musicians, Dance, History, Religion, Authors, Crafts &amp; Arts, Actors and Actresses, Athletes, Models, Performers and Comedians.&nbsp; <strong>Section B</strong> is open to both skilled and unskilled. Professionals and the unprofessional.</p>\r\n\r\n<p><strong>Warning - Users of our website must not impersonate CCS or its&rsquo; administration, employees and moderators&nbsp; of our website.&nbsp; All interested users must at all time provide true information to quality for this service.&nbsp; Management of CCS reserves the right to check identification at any given time.&nbsp; Each individual user must open their own account, no managers or companies are allowed to open an account on your behalf.&nbsp; Persons found giving false information will be remove from this site.&nbsp; Anyone whose account is remove/deactivate cannot re-apply to CCS website or any of our Internet business sites again.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Privacy Policy:</strong><br />\r\nCCS do not share any personal information submitted by our users, clients and patrons to any second or third party participants.&nbsp; Patrons and all users of CCS are, therefore, responsible for the way they disclose their information to other patrons, users or clients on this website.&nbsp; We own the sole right to discontinue any services rendered to you or deny the access of any user, patron or client, if he or she fails to comply with the rules implemented by CCS.&nbsp; Website contents, projects or events, and the mentioned offers / prices are subjected to changes from time to time, without any prior notice and the management decision regarding any kinds of dispute, if any, will be abiding.&nbsp; By accessing CCS website, all users, patrons and clients agrees to abide by all the copyright notices and restrictions attached to any and all contents including our rules.</p>\r\n\r\n<p><strong>Information collection and sharing:</strong><br />\r\nCCS recognize your rights to confidentiality and we are devoted to protecting your privacy.&nbsp; We are the sole owner of the information collected by this website and we do not rent, sell or loan any information collected by the website to others unless legally required.&nbsp; It is necessary to protect the legitimate interests of our customers and us.&nbsp; It is required to cooperate with interception orders, warrants, or other legal process that we determines in our sole discretion to be valid and enforceable.&nbsp; CCS will store your information for identity purpose, so, we can know who is on our website.&nbsp; CCS can get a better view of our website effects and progress according to our services, we derive from your information.&nbsp; CCS needs to know, how to design our products and services to suit your needs.&nbsp; If you correspond with us via E- mail, we may collect the information and store it with full confidentiality.&nbsp; It may, also, be used to provide you with information concerning our industry news, special events or features and offers suited for you.&nbsp; We disclaim any intention to censor, edit - our website by customers or others.&nbsp; We will, however, review, delete or block access to communications that may harm customers, or third parties or us.&nbsp; The grounds on which we may take such action include, but are not limited to, actual or potential violations of our Acceptable Use Policy.<br />\r\n&nbsp;&nbsp; &nbsp;<br />\r\n<strong>Passwords and Login information:</strong></p>\r\n\r\n<p>All registered users of CCS are responsible for keeping your login information in a secure manner.&nbsp; Allowing someone to sign into your account can result in you loosing your account.&nbsp; As, you would not know what a person can transact or project under your identification.&nbsp; Whatever, transpires under your name and through your account is your sole responsibility, and you will not be given pardon.&nbsp; User are not allowed to choose usernames, that is obscene, indecent, abusive or which might otherwise subject this website to public disparagement or scorn.&nbsp; All registered users must give your hometown and Country, when signing up (this&nbsp; information is not disclose to the public, you can disclose where you live at your sole discretion only).&nbsp; CCS reserve the right without prior notice to you, to automatically change your username, if it is offensive.</p>\r\n\r\n<p><strong>Modifications:</strong><br />\r\nAll customers, patrons and users may access and modify their personal information via their online personal account information page.&nbsp; Please make sure that all your information stays current and up to date.&nbsp; CCS does not allow users to sell or transfer your account to anyone, if you no longer need the use of CCS services your account will be closed. There should be no impersonation or falsification of identification, your identification should be corresponding to that which is proclaim on your birth certification e.g.:- male or female and given name.&nbsp; Please be precise and factual at all times.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Spams/Phishing:</strong><br />\r\nCCS will not tolerate the transmission of spams from our website.&nbsp; Customers caught using this website for this purpose of sending spams are fully investigated.&nbsp; Once CCS determines there is a problem with spam, we will take the appropriate action to resolve the situation. Users attempting to acquire information such as other usernames, passwords, and credit card details, will be immediately remove from our website.&nbsp; User are not allowed to transmit, bots worms, computer codes,&nbsp; &lsquo;junk mail&rsquo;, &ldquo;chain letters&rdquo;, &ldquo;unsolicited mass mailing&rdquo; and instant messaging.&nbsp; Do not alter or try to modify someone else profile without their permission.&nbsp;<strong> Do not stalk, harass, restrict or inhibit any other user from enjoying their forums.</strong></p>\r\n\r\n<p><strong>Language:</strong><br />\r\nCCS will not permit<em><strong> any verbal abuse on this website</strong></em>.&nbsp;<strong> No Atheist or Religious hate comments allowed on this website</strong>.&nbsp; As a customer using CCS, we advise you use the groups and interests that best suits you and your likings, that would not cause you any upset. To avoid being remove from this website.&nbsp; No cursing and swearing e.g. sexually <strong>&quot;F&quot; words or mother connect as a prefix, no sluts, hoes or whores, no heifer or cocks, no bitch/bitches, prostitute, no asses, cu*t, ni*g*r. Period!&nbsp; They must not appear in your works either, please edit your materials, before, posting them on this website.&nbsp; I will add more insult words as the issues arise.&nbsp; A customer may get one warning or chance only, before, your account is deactivated.&nbsp; Some incidents may not be given any pardons.&nbsp; It depends on the issue and problem that arise.&nbsp; All users agrees that you will not defame, abuse, harass, stalk, threaten or otherwise violate the legal right of other users on this website</strong>.&nbsp; Our management and staff reserves the right to delete your posts from Forums/bulletin boards.</p>\r\n\r\n<p><strong>Sales Policy:</strong><br />\r\nOur Customers are allowed to sell their materials, Literature, Photos, Books, Audio&#39;s, Videos, you must owned the full rights to it.&nbsp; Unless, you can prove by law that you have been given rights by a owner/owners to sell work, produce by them on their behalf, or a joint project.&nbsp; <strong>Caribbean Circle Stars has hereby entered into an agreement with you the users of this website program, on this sales usage agreement that it must be carried out as required by us. CCS requires 25% of all sales transacted through this website, which must be paid at the time of the said sale/sales.&nbsp; Any user of our service found not in compliance with the rule will have your account deactivated /removed</strong>. &nbsp;<br />\r\nCCS only allows the customers and users of <strong>Section B</strong> on this website to sell their Arts/Works through our website.&nbsp; No counterfeit or illegal goods are allowed to be uploaded and sole through this website, or such transactions transpired.&nbsp; Anyone, caught doing such will be penalize according to the law, the penalty is maximum.&nbsp; <strong>All Talent Users</strong> - are responsible for any goods/services sold or promise to your customers.&nbsp; The services, goods and items sold to your customers must be delivered and <strong>the&nbsp;certified receipt presented to us</strong>, before you receive your&nbsp;payment.&nbsp; As a users of CCS services, you hereby legally agree to be honest and open to your clients in any and all your business transactions and ventures.&nbsp; All CCS users in their different forms of, &#39;Arts and Works,&#39; must make their terms of sales/delivery openly known in advance with their customers.&nbsp; Please make clear your terms of return policies as regarding your goods and services with your customer and the buyers.<br />\r\n<strong>Note: All underage acts/talents below the age of 18 years, need a guardian to sign up a sales account and shopping cart on your behalf.&nbsp; Anyone, found doing sales and does not meet the age criteria will have your account suspended.</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Promotion and Advertising:</strong><br />\r\n<strong>No banners are allowed on this website from all users</strong>.&nbsp; All our users, fans, patrons, talents and arts form can post events, invitations and promotions on their profiles only.&nbsp; CCS does not allow our users to involve in any commercial activities and/ or sales without prior written consent from CCS administration in regards, to such as, sweepstakes, contests, advertising, banners.&nbsp; Users are not allowed to post your events, invitations and promotions on the profiles of other users on our website.&nbsp; Persons caught doing this will be given one warning, the second incident will cause your account to be remove/deactivated.&nbsp; <strong>Voting, competing and charting is not allowed on CCS website</strong>.&nbsp; Clients who are business owners or work in the commercial industry must only post advertisement through the approval from management of CCS (contact the CCS Administration).&nbsp; No forms of advertising should be altered after posted on or submitted to CCS.&nbsp;<strong> All individuals posting or presenting/submitting different forms of advertisement is &#39;hereby&#39; responsible and takes full penalty for any damage cause to our website, if found guilty of viral infections cause by your advertisements.&nbsp; Individuals, users and clients found causing damage will pay the full cost of repairs to the website.</strong></p>\r\n\r\n<p><strong>Materials, Photos, Data, Files, Audio&#39;s and videos, Books, Literatures:</strong><br />\r\nCCS and staff does not take responsibility for materials posted or uploaded by our customers on this website.&nbsp; It is your responsibility to keep back up files, however, you store them on your computers of all your data, files, audio&#39;s, photos and materials you upload to this website. Please make sure that all your materials/works are Copyrighted and that you are the owner and have rights to publish or post them on CCS website.&nbsp; Check with your government registrar and other offices according to your Country laws, about, Trademarks, Logos, Copyrights or Licensed for your Arts/Works.&nbsp; <strong>Do not upload files that contain viruses, corrupted files, or any other similar software or programs that may cause damage to our website, or, another person computer.</strong>&nbsp; This privilege is presented to the customers of CCS &quot;as is&quot; and is available for your use according to your discretion.&nbsp; Customers found misusing this privilege to steal, deface/devalue or exploit anyone work/art, will be remove from being a member and customer of CCS.&nbsp; Please, consult with each owner about their work and your allowed privilege and usage of their work, arts or materials.&nbsp; No child pornography, trafficking in obscene material, frauds, pyramid schemes, drug dealing and gambling are allowed.&nbsp;&nbsp; There must be no soliciting of sex buying or selling on this website.&nbsp; CCS reserves the right to investigate and take appropriate action (which may include taking legal action) against anyone who, in CCS sole discretion, violates this provision, including, without limitation, removing the offending Content from the CCS website, terminating the Membership of such violators and/ or reporting such Content or activities to law enforcement authorities. &nbsp;<br />\r\n<strong>&nbsp;Warning!<br />\r\nNo explicit materials, audio&#39;s, arts/portraits, Michael Angelo/nude sculptures, R rated comedians- language , videos, photos, files should be published on this website period! Photos or videos of men clothed in shorts/trousers, but, topless allowed, no jockeys/ undies allowed.&nbsp; Women must have on a top and bottom (very decent and appropriate) piece at all times. Bath suits and decent under wear permitted. </strong>&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><br />\r\n<strong>Agreement on Good or Service uploaded on CCS website:</strong><br />\r\nAll patrons/fans, users and clients &#39;hereby&#39; agrees to indemnify, defend and hold the Service, and all our management, directors, owners, agents, information provided, affiliates and licensors(collectively the &quot;Parties&quot;) harmless from and against any and all liability, losses, costs and expenses (including attorney&#39;s fee) incurred by any Party in connection with any claim arising out of the following:-<br />\r\nAny use or alleged use of your account or password by any person, whether or not authorized by you.&nbsp; Any claim arising out of the materials that you upload on CCS website.&nbsp; Including, but, not limited to, claims for defamation, violation of rights of publicity and/or privacy, copyright infringement, trademark infringement and any claim or liability relating to the content, quality, or performance of materials/ works that you upload to the website.&nbsp; We reserve the right, at our expense, to assume the exclusive defense and control of any matter otherwise subject to indemnification by you, and in such case, you agree to cooperate with our defense of such claim. The listing, of any document in our service search database does not imply any warranty or guarantee by us, for any companies, products, or services describe in such documents.&nbsp; We disclaim any and all responsibility or liability for the accuracy, content, completeness, legality, reliability, or operability or availability of information or material displayed in CCS search results.&nbsp; We disclaim any responsibility for the deletion, failure to store, misdelivery, or untimely delivery of any information or material/work.&nbsp; We disclaim any responsibility for any harm resulting from downloading or accessing any information or material/ work on the world Wide Web or Internet using search results from our Service.</p>\r\n\r\n<p><strong>WE DO NOT WARRANT THAT THE SERVICE WILL BE UNINTERRUPTED OR ERROR-FREE.&nbsp; IN ADDITION, WE DO NOT MAKE ANY WARRANTY AS TO THE RESULTS TO BE OBTAINED FROM USE OF THE SERVICE OR CONTENT.&nbsp; THE SERVICE AND THE CONTENT ARE DISTRIBUTED ON AN &quot;AS IS&quot;, AS AVAILABLE&quot;&nbsp; BASIS.&nbsp; ANY MATERIAL DOWNLOADED OR OTHER WISE OBTAINED THROUGH THE SERVICE IS DONE AT YOUR OWN DISCRETION AND RISK, AND YOU WILL BE SOLELY RESPONSIBLE FOR POTENTIAL DAMAGES TO YOUR COMPUTER SYSTEM OR LOSS OF DATA THE RESULTS FROM THE DOWNLOAD OF ANY SUCH MATERIAL.&nbsp; WE DO NOT MAKE ANY WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING, WITHOUT LIMITATION, WARRANTIES OF TITLE OR IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE, WITH RESPECT TO THE SERVICE, ANY CONTENT OR ANY PRODUCTS OR SERVICES SOLD THROUGH THE SERVICE. YOU EXPRESSLY AGREE THAT YOU WILL ASSUME THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE SERVICE AND THE ACCURACY OR COMPLETENESS OF ITS CONTENT.&nbsp; WE SHALL NOT BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF THE USE OF OR INABILITY TO USE THE SERVICE, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. WE RESERVE THE RIGHT TO TERMINATE THE SERVICE AT ANY TIME WITH MINIMUM NOTICE OR WITHOUT NOTICE.</strong></p>\r\n\r\n<p>By the management of CCS.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n\r\n<p>Copyright 2013 &copy;</p>\r\n\r\n<p>&nbsp;</p>\r\n', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE IF NOT EXISTS `tbl_contact` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `job_title` varchar(255) DEFAULT NULL,
  `query_subject` varchar(255) DEFAULT NULL,
  `query` varchar(255) DEFAULT NULL,
  `file_attached` varchar(255) DEFAULT NULL,
  `file_type` enum('1','2','3','4','5') NOT NULL COMMENT '''1''->audio,''2''->photo,''3''->document,''4''->flyers,''5''->videos',
  `file_title` varchar(255) NOT NULL,
  `audio_albm_name` varchar(255) NOT NULL,
  `audio_artist` varchar(255) NOT NULL,
  `audio_year` varchar(255) NOT NULL,
  `photo_model_name` varchar(255) NOT NULL,
  `photo_photographer` varchar(255) NOT NULL,
  `doc_owner` varchar(255) NOT NULL,
  `join_date` varchar(50) NOT NULL,
  `join_time` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `name`, `email`, `company`, `job_title`, `query_subject`, `query`, `file_attached`, `file_type`, `file_title`, `audio_albm_name`, `audio_artist`, `audio_year`, `photo_model_name`, `photo_photographer`, `doc_owner`, `join_date`, `join_time`) VALUES
(72, 'Rahul', 'savtar750@gmail.com', 'test', 'software engineer', 'test', 'testtest', 'uploadcontact/8521574812014-09-09-22-34-18.mp3', '1', 'Pal Pal Bade Yeh Hai Mohabbatein', 'Mohabbatein', 'Tripti', '2009', '', '', '', '2014-09-09', '10:34:18 PM'),
(91, 'Tammy Dey', 'yonel.1@netzero.com', 'Coscous', 'Manager', 'Adds', 'I will some more info on the adds.', 'uploadcontact/7647290892014-09-28-21-55-29.mp3', '1', 'Cya Cum', 'Chutney soca', 'Ravi B', '2013', '', '', '', '2014-09-28', '09:55:34 PM'),
(70, 'Rahul', 'savtar750@gmail.com', 'test', 'software engineer', 'test', 'testtest', 'uploadcontact/20103012722014-09-09-22-22-04.mp4', '5', 'Video', '', '', '', '', '', '', '2014-09-09', '10:22:04 PM'),
(96, 'MayankTiwari', 'tiwari.mayank24@gmail.com', 'vmt soft', 'software developer', 'Testing form', 'hello world', 'uploadcontact/small96.jpg', '2', 'hellowrold', '', '', '', 'somemodel', 'mayank', '', '2014-10-05', '08:14:52 AM'),
(95, 'Mayank Tiwari', 'tiwari.mayank24@gmail.com', 'vmt soft', 'software developer', 'Testing form', 'Nothing just testing this form', 'uploadcontact/15745419052014-10-05-06-25-23.mp3', '1', 'test song', 'test alum', 'test artist', '2014', '', '', '', '2014-10-05', '06:25:23 AM'),
(90, 'admin', 'guptakg91@gmail.com', 'admin', 'admin', 'admin', 'askdjasdl', 'uploadcontact/10475983502014-09-26-11-41-52.mp4', '5', 'video', '', '', '', '', '', '', '2014-09-26', '11:42:03 AM'),
(94, 'admin', 'admin@gmail.com', 'admin', 'admin', 'admin', 'dskfjlsjk', 'uploadcontact/small94.jpg', '2', 'admin', '', '', '', 'admin', 'admin', '', '2014-09-30', '12:49:28 AM'),
(97, 'Rahul', 'ajitabhshakya007@gmail.com', 'test', 'software engineer', 'test', 'gggggggggggggggggggggg', 'uploadcontact/small97.jpg', '2', 'Charlie', '', '', '', 'charlie', 'rahul', '', '2014-10-06', '02:38:59 PM'),
(98, 'ddd', 'ajitabhshakya007@gmail.com', 'test', 'test', 'test', 'nnnnnnnnnnnnnnnn', 'uploadcontact/small98.jpg', '2', 'ssssssssssssss', '', '', '', 'ssssssssssss', 'sssssssss', '', '2014-10-06', '03:19:21 PM'),
(99, 'mannu', 'tiwari.mayank24@gmail.com', 'helloworld', 'helloworld', 'helloworsd', 'asdfasdfasdf', 'uploadcontact/small99.jpg', '2', 'asdf', '', '', '', 'asdfadsf', 'asdf', '', '2014-10-07', '12:58:33 PM'),
(100, 'Tammy Dey', 'yonel.1@netzero.com', 'Tres Promotion ', 'Asst Editor', 'Photo ', 'Here is the photo let me know if you like it.Thanks', 'uploadcontact/small100.jpg', '2', 'Make-up', '', '', '', 'DIEYNA VALERA', 'Kingston', '', '2014-10-07', '10:34:41 PM'),
(101, 'Rahul', 'ajitabhshakya007@gmail.com', 'test', 'test', 'test', 'fffffffff', 'uploadcontact/21300485282014-10-10-16-33-48.mp3', '1', 'Pal Pal Bade Yeh Hai Mohabbateinnnn', 'Mohabbatein', 'Tripti', '2009', '', '', '', '2014-10-10', '04:33:48 PM'),
(107, 'Tammy Dey', 'yonel.1@netzero.com', 'Glamgo', 'Asst Editor', 'Photo', 'Sent photo', 'uploadcontact/small107.jpg', '2', 'Make-up', '', '', '', 'cindy', 'Ralph Lowe', '', '2014-10-14', '01:25:15 PM'),
(106, 'Rahul', 'ajitabhshakya007@gmail.com', 'test', 'test', 'test', 'rrrrrrrrr', 'uploadcontact/718019402014-10-14-13-17-51.jpg', '2', 'new infront of you', '', '', '', 'new infront of you', 'new infront of you', '', '2014-10-14', '01:17:51 PM'),
(105, 'Rahul', 'ajitabhshakya007@gmail.com', 'test', 'test', 'test', 'rrrrrrrrrrrr', 'uploadcontact/17138652302014-10-13-00-42-48.jpg', '2', 'Charlie', '', '', '', 'charlie', 'test', '', '2014-10-13', '12:42:48 AM');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contactrecords`
--

CREATE TABLE IF NOT EXISTS `tbl_contactrecords` (
`id` int(11) NOT NULL,
  `contactid` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_contactrecords`
--

INSERT INTO `tbl_contactrecords` (`id`, `contactid`, `page_name`, `created_at`) VALUES
(1, 81, 'Home', '2014-07-01 23:15:21'),
(2, 82, 'Spotlight', '2014-07-01 23:15:31'),
(3, 83, 'Forum', '2014-07-01 23:15:41'),
(4, 81, 'Forum', '2014-07-01 23:32:23'),
(5, 83, 'Spotlight', '2014-07-01 23:35:50'),
(6, 81, 'Forum', '2014-07-01 23:45:55'),
(7, 82, 'Spotlight', '2014-07-01 23:46:09'),
(8, 6, 'Spotlight', '2014-07-20 03:37:36'),
(9, 6, 'Forum', '2014-07-20 03:37:50'),
(10, 11, 'Home', '2014-07-20 03:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_donate`
--

CREATE TABLE IF NOT EXISTS `tbl_donate` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `message` text,
  `join_date` varchar(50) NOT NULL,
  `join_time` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_donate`
--

INSERT INTO `tbl_donate` (`id`, `name`, `email`, `amount`, `message`, `join_date`, `join_time`) VALUES
(17, 'rahul', 'rahulshakya1987@gmail.com', '50', 'ffffff', '2014-10-13', '11:55:47 AM'),
(10, 'test', 'test@yahoo.com', '1', 'This is testing.', '2014-01-26', '01:57:09 PM'),
(11, 'test', 'test@test.com', '100', 'asdfasfd', '2014-01-29', '10:47:01 PM'),
(12, 'Joe John', 'yonel.1@netzero.net', '2', 'Thank you', '2014-01-31', '10:48:23 AM'),
(13, 'Joe John', 'yonel.1@netzero.net', '1', 'thanks  a lot', '2014-01-31', '10:55:03 AM'),
(14, 'Joe John', 'yonel.1@netzero.net', '1', 'Thanks', '2014-01-31', '01:34:07 PM'),
(15, 'Joe John', 'yonel.1@netzero.net', '3', 'Thanks', '2014-01-31', '01:38:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fans`
--

CREATE TABLE IF NOT EXISTS `tbl_fans` (
`id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `fan_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_fans`
--

INSERT INTO `tbl_fans` (`id`, `profile_id`, `fan_id`) VALUES
(1, 106, 130),
(2, 130, 106),
(3, 106, 105),
(4, 105, 106);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_featured_artists`
--

CREATE TABLE IF NOT EXISTS `tbl_featured_artists` (
`id` int(11) NOT NULL,
  `f_artists_name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_featured_artists`
--

INSERT INTO `tbl_featured_artists` (`id`, `f_artists_name`, `status`) VALUES
(3, 'MONSOON', 1),
(4, 'George Wildlife Scott', 1),
(5, 'Khalilah Rose', 1),
(6, 'Tony Ice', 1),
(7, 'Jawara', 1),
(9, 'Chappa Jan', 1),
(16, 'Phanuel', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum_reply`
--

CREATE TABLE IF NOT EXISTS `tbl_forum_reply` (
`id` bigint(20) NOT NULL,
  `forum_id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `reply_text` longtext NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_admin` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_forum_reply`
--

INSERT INTO `tbl_forum_reply` (`id`, `forum_id`, `uid`, `reply_text`, `post_time`, `is_admin`) VALUES
(10, 1, 0, '<p><img src=\\"/ckeditor/plugins/doksoft_uploader/userfiles/1_Desert.jpg\\" style=\\"height:700px; width:585px\\" /></p>\r\n\r\n<p>CCS website is set up to provide our users with opportunities to market their products more effectively to both the Caribbean and the international market. &nbsp;Our website is equipped with a shopping cart to accommodate users, who would like to sell their works and arts.</p>', '2014-01-28 12:49:41', 'Yes'),
(11, 1, 0, '<p><img src=\\"/ckeditor/plugins/doksoft_uploader/userfiles/Bird-landing.jpg\\" style=\\"height:1000px; width:592px\\" /></p>\r\n\r\n<p>&nbsp;There were a couple of surprises with the actual awards, too. Macklemore &amp; Ryan Lewis did win best new artist, but was absent from other major categories. &ldquo;Conventional wisdom was that Macklemore was going to clean up,&rdquo; Lefsetz said.&nbsp;</p>', '2014-01-31 09:20:48', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_forum_topics`
--

CREATE TABLE IF NOT EXISTS `tbl_forum_topics` (
`id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL DEFAULT '0',
  `forum_topic` varchar(255) NOT NULL,
  `forum_details` longtext NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `view_count` bigint(20) NOT NULL,
  `is_admin` enum('Yes','No') NOT NULL DEFAULT 'No'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_msg`
--

CREATE TABLE IF NOT EXISTS `tbl_msg` (
`id` bigint(20) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `sub` text NOT NULL,
  `msg` text NOT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `view_status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE IF NOT EXISTS `tbl_orders` (
`id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `uid` int(11) NOT NULL,
  `seller_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_amt` float(20,2) NOT NULL,
  `shipping_amt` float(20,2) NOT NULL,
  `total_amt` float(20,2) NOT NULL,
  `order_status` tinyint(4) NOT NULL,
  `payment_status` tinyint(4) NOT NULL,
  `buyer_feedback` text
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_shipping`
--

CREATE TABLE IF NOT EXISTS `tbl_order_shipping` (
`id` bigint(11) NOT NULL,
  `order_id` bigint(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(160) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `country` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE IF NOT EXISTS `tbl_products` (
`id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `product_details` text NOT NULL,
  `product_price` float NOT NULL,
  `shipping` tinyint(1) NOT NULL COMMENT '0=no shipping, 1=yes',
  `p_shipping` float(20,2) NOT NULL,
  `video_code` text NOT NULL,
  `content_type` int(11) NOT NULL COMMENT 'normal=0,mp3=1,video=2,photo=3,book=4,event=5',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`id`, `uid`, `ref_id`, `product_name`, `product_details`, `product_price`, `shipping`, `p_shipping`, `video_code`, `content_type`, `status`) VALUES
(2, 20, 1, 'Don''t Trick Me - Kym Hamilton', '', 0.99, 0, 0.00, '', 1, 1),
(3, 20, 2, 'Your Eyes - Khalilah Rose', '', 1, 0, 0.00, '', 1, 1),
(4, 20, 2, 'Sugar Cane', '“You live in a tower without a stair,\r\nSugar Cane, Sugar Cane, let down your hair.”\r\n\r\nStolen away from her parents on her first birthday by island sorceress Madam Fate, beautiful Sugar Cane grows up in a tower overlooking the sea. With only a pet green monkey named Callaloo for company, Sugar Cane is lonely—her only consolation is her love of music. Often she stands at her window and sings, imagining that the echo of her voice is someone answering her. Then one night, someone does hear her song, but could this young man with a gift for music break the spell of Madam Fate and help Sugar Cane set herself free?', 8.5, 1, 5.00, '', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_books`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_books` (
`id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `name` varchar(150) NOT NULL,
  `author` varchar(150) NOT NULL,
  `book_details` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile_books`
--

INSERT INTO `tbl_profile_books` (`id`, `uid`, `name`, `author`, `book_details`, `status`) VALUES
(2, 20, 'Sugar Cane', 'Patricia Storace', '“You live in a tower without a stair,\r\nSugar Cane, Sugar Cane, let down your hair.”\r\n\r\nStolen away from her parents on her first birthday by island sorceress Madam Fate, beautiful Sugar Cane grows up in a tower overlooking the sea. With only a pet green monkey named Callaloo for company, Sugar Cane is lonely—her only consolation is her love of music. Often she stands at her window and sings, imagining that the echo of her voice is someone answering her. Then one night, someone does hear her song, but could this young man with a gift for music break the spell of Madam Fate and help Sugar Cane set herself free?', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_comments`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_comments` (
`id` bigint(20) NOT NULL,
  `profile_id` bigint(20) NOT NULL,
  `commenter_id` bigint(20) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_events`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_events` (
`id` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` varchar(100) NOT NULL,
  `event_details` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `buy_url` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_images`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_images` (
`id` int(11) unsigned NOT NULL,
  `userid` int(11) NOT NULL,
  `desc` text NOT NULL,
  `imagename` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `createddate` datetime NOT NULL,
  `updateddate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile_images`
--

INSERT INTO `tbl_profile_images` (`id`, `userid`, `desc`, `imagename`, `status`, `createddate`, `updateddate`) VALUES
(24, 20, '', '24.jpg', 1, '2014-10-14 19:35:41', '2014-10-14 19:35:41'),
(15, 22, '', '15.jpg', 1, '2014-10-06 19:40:19', '2014-10-06 19:40:19'),
(16, 22, '', '16.jpg', 1, '2014-10-06 19:43:06', '2014-10-06 19:43:06'),
(9, 0, '', '9.jpg', 1, '2014-10-05 17:12:12', '2014-10-05 17:12:12'),
(18, 34, '', '18.jpg', 1, '2014-10-13 04:29:24', '2014-10-13 04:29:24'),
(25, 20, '', '25.jpg', 1, '2014-10-14 20:27:53', '2014-10-14 20:27:53'),
(20, 54, '', '20.jpg', 1, '2014-10-14 18:35:11', '2014-10-14 18:35:11'),
(23, 20, '', '23.jpg', 1, '2014-10-14 18:58:47', '2014-10-14 18:58:47'),
(22, 54, '', '22.jpg', 1, '2014-10-14 18:43:52', '2014-10-14 18:43:52'),
(28, 53, '', '28.jpg', 1, '2014-10-14 21:06:05', '2014-10-14 21:06:05'),
(29, 20, '', '29.jpg', 1, '2014-10-14 21:19:31', '2014-10-14 21:19:31'),
(30, 53, '', '30.jpg', 1, '2014-10-14 21:21:58', '2014-10-14 21:21:58'),
(31, 53, '', '31.jpg', 1, '2014-10-14 21:29:39', '2014-10-14 21:29:39'),
(33, 53, '', '33.jpg', 1, '2014-10-14 21:34:48', '2014-10-14 21:34:48'),
(34, 20, '', '34.jpg', 1, '2014-10-14 21:38:08', '2014-10-14 21:38:08'),
(35, 53, '', '35.jpg', 1, '2014-10-14 21:39:51', '2014-10-14 21:39:51'),
(36, 53, '', '36.jpg', 1, '2014-10-14 21:41:27', '2014-10-14 21:41:27'),
(37, 20, '', '37.jpg', 1, '2014-10-14 21:41:41', '2014-10-14 21:41:41'),
(38, 20, '', '38.jpg', 1, '2014-10-14 21:43:36', '2014-10-14 21:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_music`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_music` (
`id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `music_title` varchar(100) NOT NULL,
  `music_details` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile_music`
--

INSERT INTO `tbl_profile_music` (`id`, `user_id`, `music_title`, `music_details`, `status`) VALUES
(1, 20, 'Don''t Trick Me - Kym Hamilton', '', 1),
(2, 20, 'Your Eyes - Khalilah Rose', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_photos`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_photos` (
`id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `photo_title` varchar(100) NOT NULL,
  `photo_details` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile_photos`
--

INSERT INTO `tbl_profile_photos` (`id`, `user_id`, `photo_title`, `photo_details`, `status`) VALUES
(3, 20, 'Chilling', 'Relaxing', 1),
(2, 15, 'test', 'test', 1),
(4, 20, 'Top Model', 'Model contest', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profile_videos`
--

CREATE TABLE IF NOT EXISTS `tbl_profile_videos` (
`id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `video_name` varchar(100) NOT NULL,
  `video_type` tinyint(1) NOT NULL COMMENT '0=youtube, 1=file',
  `video_code` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_profile_videos`
--

INSERT INTO `tbl_profile_videos` (`id`, `user_id`, `video_name`, `video_type`, `video_code`, `status`) VALUES
(2, 20, 'Sick Like Duh', 0, '<iframe width="560" height="315" src="//www.youtube.com/embed/Uqs4uuq8cPY" frameborder="0" allowfullscreen></iframe>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seller_bank`
--

CREATE TABLE IF NOT EXISTS `tbl_seller_bank` (
`id` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `routing_number` varchar(30) NOT NULL,
  `bank_address` varchar(100) NOT NULL,
  `bank_address_2` varchar(100) NOT NULL,
  `bank_city` varchar(20) NOT NULL,
  `bank_state` varchar(20) NOT NULL,
  `bank_zip_code` varchar(10) NOT NULL,
  `account_holder_name` varchar(30) NOT NULL,
  `accountnumber_iban` varchar(30) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_seller_bank`
--

INSERT INTO `tbl_seller_bank` (`id`, `uid`, `bank_name`, `country`, `routing_number`, `bank_address`, `bank_address_2`, `bank_city`, `bank_state`, `bank_zip_code`, `account_holder_name`, `accountnumber_iban`) VALUES
(3, 20, 'Republic Bank', '5-246', '12000040057', 'Independence Square', '', 'Bridgetown', 'Barbados', '', 'Rosalie King', '231145110000');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shopping_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_shopping_cart` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_price` float(20,2) NOT NULL,
  `p_shipping` float(20,2) NOT NULL,
  `add_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_site_music`
--

CREATE TABLE IF NOT EXISTS `tbl_site_music` (
`id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `artist` varchar(55) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `media_id` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_site_music`
--

INSERT INTO `tbl_site_music` (`id`, `name`, `artist`, `status`, `media_id`) VALUES
(44, 'Cyaan Nyam We Out', 'GAVINCHI BROWN', 1, 0),
(45, 'Not Giving Up', 'Khalilah Rose', 1, 0),
(46, 'I-View', 'Neat Ana Step', 1, 0),
(47, 'Axum Border', 'Addis Pablo', 1, 0),
(48, 'TOUCH YOU', 'Chappa Jan', 1, 0),
(49, 'My Lady', 'Mr. Lee-G', 1, 0),
(50, 'No Man Cant Talk Bad Bout Mi', 'Tiana - Dancehall Duchess', 1, 0),
(51, 'Gimmie Gimmie', 'Kimba Sorzano', 1, 0),
(52, 'Every Little Thing', 'Mr. Lee-G-with prod.KID', 1, 0),
(53, 'Pretty Girl', 'Mr. Mazin-Mr. Mazin - (Prosonic Prod)', 1, 0),
(54, 'Look Around', 'Jah-Levi', 1, 0),
(55, 'Nadie como tu', 'Gangster', 1, 0),
(56, 'SET ME ON A HIGH', 'Ras Khaleel ft O-Dub', 1, 0),
(57, 'Never Stay Away', 'Jodian Pantry', 1, 0),
(58, 'Ghost Remix', 'Dobson ft Curtisay-Fefe', 1, 0),
(59, 'Don''t Trick Me', 'Kym Hamilton', 1, 0),
(60, 'SO BEAUTIFUL', 'Ras Khaleel', 1, 0),
(61, 'REAL LOVE', 'CHAPPA JAN w NATASJA', 1, 0),
(62, 'VICTORY', 'Chappa Jan', 1, 0),
(63, 'Drunk Off Your Love', 'Aisha Davis', 1, 0),
(64, 'Can''t Bully Me Down', 'Lutan Fyah', 1, 0),
(65, 'It''s Love', 'Shurwayne Winchester', 1, 0),
(66, 'Hold A Medz', 'Lutan Fyah', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_talents`
--

CREATE TABLE IF NOT EXISTS `tbl_talents` (
`id` int(11) NOT NULL,
  `talent` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_talents`
--

INSERT INTO `tbl_talents` (`id`, `talent`, `status`) VALUES
(1, 'Musicians', 1),
(2, 'Arts ', 1),
(3, 'Crafts', 1),
(4, 'Literature', 1),
(5, 'Models', 1),
(6, 'Comedians', 1),
(7, 'Actors', 1),
(8, 'Singers', 1),
(9, 'Poets', 1),
(10, 'Sports', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_talent_payment_method`
--

CREATE TABLE IF NOT EXISTS `tbl_talent_payment_method` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `method` tinyint(1) NOT NULL COMMENT '1=bank 2=paypal',
  `details_payple` varchar(100) NOT NULL,
  `details` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
`id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone_no` varchar(30) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(20) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=male 2=felame',
  `age` date NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '0=nontalent, 1=talent',
  `talent` varchar(50) NOT NULL,
  `payment_details` text,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `joining_time` varchar(254) DEFAULT NULL,
  `join_date` varchar(255) DEFAULT NULL,
  `suspend_from` datetime DEFAULT NULL,
  `suspend_to` datetime DEFAULT NULL,
  `is_block_admin` enum('Yes','No') NOT NULL DEFAULT 'No',
  `mac_address` varchar(5000) NOT NULL,
  `new_mac_req` varchar(5000) NOT NULL,
  `allowed_mac` int(11) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `first_name`, `last_name`, `username`, `password`, `phone_no`, `email`, `city`, `country`, `sex`, `age`, `type`, `talent`, `payment_details`, `status`, `joining_time`, `join_date`, `suspend_from`, `suspend_to`, `is_block_admin`, `mac_address`, `new_mac_req`, `allowed_mac`) VALUES
(17, 'admin', 'admin', 'admin', 'admin123', '9460653555', 'admin@gmail.com', 'jaipur', '1', 1, '1997-02-21', 0, '', NULL, 1, '11:24:32 AM', '2014-09-29', NULL, NULL, 'No', '19fd7dcd4a65b06456ec73c88', '', 1),
(18, 'admin', 'admin', 'admin2', 'admin123', '9460653555', 'admin2@gmail.com', 'Alwar', '1', 1, '1997-02-21', 0, '', NULL, 0, '11:31:11 AM', '2014-09-29', NULL, NULL, 'No', '19fd7dcd4a65b06456ec73c88', '1', 1),
(19, 'Dave', 'Dankison', 'Daveboy', 'diswonw', '7183215354', 'yonel.1@netzero.net', 'Brooklyn', '225', 1, '1994-02-17', 0, '', NULL, 1, '11:56:38 PM', '2014-09-29', NULL, NULL, 'No', 'a585312b01009f447bfc3894b', '0', 2),
(20, 'Rosalie', 'King', 'RosaKing', 'rosintno', '2463215354', 'vano31@netzero.com', 'Bridgetown', '5', 2, '1998-02-19', 1, '5', NULL, 0, '12:06:39 AM', '2014-09-30', NULL, NULL, 'No', 'a585312b01009f447bfc3894b', '0', 2),
(55, 'test', 'test', 'rahushakya', '123456', '9971582411', 'rahulshakyaweb@gmail.com', 'New delhi', '15', 1, '0000-00-00', 1, '1,2', NULL, 0, '03:55:57 PM', '2014-10-14', NULL, NULL, 'No', '8581ba0ff98fcf0cdcf376fb2', '1', 1),
(41, 'test', 'test', 'lakhpat', '123', '9971582411', 'lakhpatshakya@gmail.com', 'New delhi', '98', 1, '1982-01-01', 0, '', NULL, 0, '11:48:56 AM', '2014-10-13', NULL, NULL, 'No', '7638bb4a3a377238db1cdf655', '1', 1),
(53, 'test', 'test', 'rahusha', '123456', '9971582411', 'rahulshakya1987@gmail.com', 'New delhi', '18', 1, '0000-00-00', 1, '1,2,3,4', NULL, 1, '12:52:27 PM', '2014-10-14', NULL, NULL, 'No', '8581ba0ff98fcf0cdcf376fb2', '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_activity`
--

CREATE TABLE IF NOT EXISTS `tbl_user_activity` (
`id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `activity` varchar(255) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_activity`
--

INSERT INTO `tbl_user_activity` (`id`, `user_id`, `activity`, `activity_time`) VALUES
(104, 20, 'RosaKing Added a new Photo Chilling', '2014-10-08 03:18:22'),
(145, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:39:51'),
(144, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 21:38:08'),
(143, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:34:48'),
(142, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:31:43'),
(103, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-08 02:43:01'),
(101, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:40:19'),
(102, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:43:06'),
(98, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:13:13'),
(99, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:27:37'),
(100, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:35:45'),
(97, 22, 'username Added/Changed Profile Picture ', '2014-10-06 19:06:40'),
(94, 19, 'Daveboy Added/Changed Profile Picture ', '2014-09-30 04:10:22'),
(95, 0, ' Added/Changed Profile Picture ', '2014-10-05 17:12:12'),
(96, 22, 'username Added/Changed Profile Picture ', '2014-10-06 17:19:00'),
(54, 0, 'admin AC12 test forum', '2014-01-28 14:28:47'),
(117, 34, 'rahusha Added/Changed Profile Picture ', '2014-10-13 04:29:24'),
(116, 34, ' has Joined CCS ', '2014-10-13 04:26:48'),
(110, 23, ' has Joined CCS ', '2014-10-11 02:53:19'),
(111, 23, ' has Joined CCS ', '2014-10-11 02:53:20'),
(112, 27, ' has Joined CCS ', '2014-10-11 17:00:35'),
(113, 27, ' has Joined CCS ', '2014-10-11 17:00:35'),
(114, 30, ' has Joined CCS ', '2014-10-12 21:47:24'),
(115, 30, ' has Joined CCS ', '2014-10-12 21:47:24'),
(109, 20, 'RosaKing Added a new Music Your Eyes - Khalilah Rose', '2014-10-09 18:15:32'),
(141, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:29:39'),
(140, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:21:58'),
(139, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 21:19:31'),
(138, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:06:05'),
(137, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 20:54:46'),
(136, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 20:51:17'),
(135, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 20:27:53'),
(134, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 19:35:41'),
(133, 20, 'RosaKing Added a new Book Sugar Cane', '2014-10-14 19:29:54'),
(128, 20, 'RosaKing Added a new Video Sick Like Duh', '2014-10-14 18:24:31'),
(127, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 17:57:38'),
(107, 19, 'Daveboy Added/Changed Profile Picture ', '2014-10-08 15:14:59'),
(108, 20, 'RosaKing Added a new Music Don''t Trick Me - Kym Hamilton', '2014-10-09 18:01:40'),
(126, 54, ' has Joined CCS ', '2014-10-14 16:55:46'),
(125, 53, ' has Joined CCS ', '2014-10-14 16:53:07'),
(132, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 18:58:47'),
(131, 54, 'rahushakya Added/Changed Profile Picture ', '2014-10-14 18:43:52'),
(130, 54, 'rahushakya Added/Changed Profile Picture ', '2014-10-14 18:37:08'),
(129, 54, 'rahushakya Added/Changed Profile Picture ', '2014-10-14 18:35:11'),
(118, 36, ' has Joined CCS ', '2014-10-13 06:04:07'),
(106, 19, 'Daveboy Added/Changed Profile Picture ', '2014-10-08 15:14:21'),
(105, 20, 'RosaKing Added a new Photo Top Model', '2014-10-08 03:21:31'),
(146, 53, 'rahusha Added/Changed Profile Picture ', '2014-10-14 21:41:27'),
(147, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 21:41:41'),
(148, 20, 'RosaKing Added/Changed Profile Picture ', '2014-10-14 21:43:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_details`
--

CREATE TABLE IF NOT EXISTS `tbl_user_details` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `biography` longtext NOT NULL,
  `social_link1` varchar(255) NOT NULL,
  `social_link2` varchar(255) NOT NULL,
  `social_link3` varchar(255) NOT NULL,
  `social_link4` varchar(255) NOT NULL,
  `profile_display_status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_details`
--

INSERT INTO `tbl_user_details` (`id`, `user_id`, `biography`, `social_link1`, `social_link2`, `social_link3`, `social_link4`, `profile_display_status`) VALUES
(8, 20, 'The Rio Isabel Correa is very well known in the world of beauty pageants. Competed in the Miss Brazil World 2009 (competed with a class that yields up to today: Mariana Notarangelo , Karine Barros and Lorena Bueri ) and Miss RJ in 2008, when he finished in 2nd place. This year she returns to compete in the state contest for Teresopolis.\r\n\r\nOh, and she also participated in Brazil''s Next Top Model.', 'https://pt-br.facebook.com/pages/Isabel-Correa/184846588313804', 'https://twitter.com/isabel_correa', '', '', 0),
(9, 19, 'Everyone’s economic and life situation is unique, and I keep that in mind when providing financial security advice. I believe that personalized service is essential when matching clients with the right financial security products and services.As a Financial Security Advisor, I am dedicated to learning about your personal goals. Together we will use them to build a financial security plan focused on your specific needs.\r\n\r\nI understand my clients are in different stages of life: you might be purchasing a first home, financing a child’s post-secondary education or planning for retirement. I believe a financial security plan must reflect your personal or business situation, and so will work to highlight the financial security products that best fit your goals. Once your custom-tailored financial plan is in place, we will continue working together to review achievements against your stated aims, and ensure you are comfortable everything is moving forward according to plan.', 'https://www.facebook.com/kendell.j.smith?ref=br_tf', '', '', '', 0),
(10, 23, ' ', '', '', '', '', 1),
(11, 23, ' ', '', '', '', '', 1),
(12, 27, ' ', '', '', '', '', 1),
(13, 27, ' ', '', '', '', '', 1),
(14, 30, ' ', '', '', '', '', 1),
(15, 30, ' ', '', '', '', '', 1),
(17, 36, ' ', '', '', '', '', 1),
(24, 53, ' ', '', '', '', '', 1),
(25, 54, ' ', '', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_online`
--

CREATE TABLE IF NOT EXISTS `tbl_user_online` (
  `uid` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_profile_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_user_profile_settings` (
`id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `profile_display_status` tinyint(4) NOT NULL,
  `p_photo` tinyint(4) NOT NULL,
  `p_bio` tinyint(4) NOT NULL,
  `p_music` tinyint(4) NOT NULL,
  `p_social` tinyint(4) NOT NULL,
  `p_fans` tinyint(4) NOT NULL,
  `p_video` tinyint(4) NOT NULL,
  `p_comments` tinyint(4) NOT NULL,
  `p_event` tinyint(4) NOT NULL,
  `p_book` tinyint(4) NOT NULL,
  `p_product` tinyint(4) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_profile_settings`
--

INSERT INTO `tbl_user_profile_settings` (`id`, `uid`, `profile_display_status`, `p_photo`, `p_bio`, `p_music`, `p_social`, `p_fans`, `p_video`, `p_comments`, `p_event`, `p_book`, `p_product`) VALUES
(13, 22, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(21, 30, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(12, 20, 0, 3, 1, 2, 1, 2, 3, 3, 2, 1, 2),
(14, 23, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(15, 24, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(16, 25, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(17, 26, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(18, 27, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(19, 28, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(20, 29, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(22, 31, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(23, 32, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(24, 33, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(25, 34, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(26, 35, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(27, 36, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(28, 37, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(29, 38, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(45, 55, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(42, 52, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(43, 53, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2),
(44, 54, 0, 1, 1, 2, 2, 2, 3, 3, 2, 1, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin_login`
--
ALTER TABLE `tbl_admin_login`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms`
--
ALTER TABLE `tbl_cms`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_contactrecords`
--
ALTER TABLE `tbl_contactrecords`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_donate`
--
ALTER TABLE `tbl_donate`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_fans`
--
ALTER TABLE `tbl_fans`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_featured_artists`
--
ALTER TABLE `tbl_featured_artists`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_forum_reply`
--
ALTER TABLE `tbl_forum_reply`
 ADD PRIMARY KEY (`id`), ADD KEY `forum_id` (`forum_id`,`uid`);

--
-- Indexes for table `tbl_forum_topics`
--
ALTER TABLE `tbl_forum_topics`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `tbl_msg`
--
ALTER TABLE `tbl_msg`
 ADD PRIMARY KEY (`id`), ADD KEY `from_id` (`from_id`,`to_id`,`send_date`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order_shipping`
--
ALTER TABLE `tbl_order_shipping`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`,`product_name`);

--
-- Indexes for table `tbl_profile_books`
--
ALTER TABLE `tbl_profile_books`
 ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `tbl_profile_comments`
--
ALTER TABLE `tbl_profile_comments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_profile_events`
--
ALTER TABLE `tbl_profile_events`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_profile_images`
--
ALTER TABLE `tbl_profile_images`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_profile_music`
--
ALTER TABLE `tbl_profile_music`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_profile_photos`
--
ALTER TABLE `tbl_profile_photos`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_profile_videos`
--
ALTER TABLE `tbl_profile_videos`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_seller_bank`
--
ALTER TABLE `tbl_seller_bank`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_shopping_cart`
--
ALTER TABLE `tbl_shopping_cart`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_site_music`
--
ALTER TABLE `tbl_site_music`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_talents`
--
ALTER TABLE `tbl_talents`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `talent` (`talent`);

--
-- Indexes for table `tbl_talent_payment_method`
--
ALTER TABLE `tbl_talent_payment_method`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `email` (`email`);

--
-- Indexes for table `tbl_user_activity`
--
ALTER TABLE `tbl_user_activity`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`,`activity_time`);

--
-- Indexes for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_online`
--
ALTER TABLE `tbl_user_online`
 ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `tbl_user_profile_settings`
--
ALTER TABLE `tbl_user_profile_settings`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_admin_login`
--
ALTER TABLE `tbl_admin_login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_chat`
--
ALTER TABLE `tbl_chat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_cms`
--
ALTER TABLE `tbl_cms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_contact`
--
ALTER TABLE `tbl_contact`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=108;
--
-- AUTO_INCREMENT for table `tbl_contactrecords`
--
ALTER TABLE `tbl_contactrecords`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_donate`
--
ALTER TABLE `tbl_donate`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tbl_fans`
--
ALTER TABLE `tbl_fans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_featured_artists`
--
ALTER TABLE `tbl_featured_artists`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `tbl_forum_reply`
--
ALTER TABLE `tbl_forum_reply`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `tbl_forum_topics`
--
ALTER TABLE `tbl_forum_topics`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_msg`
--
ALTER TABLE `tbl_msg`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_order_shipping`
--
ALTER TABLE `tbl_order_shipping`
MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_profile_books`
--
ALTER TABLE `tbl_profile_books`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_profile_comments`
--
ALTER TABLE `tbl_profile_comments`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_profile_events`
--
ALTER TABLE `tbl_profile_events`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_profile_images`
--
ALTER TABLE `tbl_profile_images`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `tbl_profile_music`
--
ALTER TABLE `tbl_profile_music`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_profile_photos`
--
ALTER TABLE `tbl_profile_photos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_profile_videos`
--
ALTER TABLE `tbl_profile_videos`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_seller_bank`
--
ALTER TABLE `tbl_seller_bank`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_shopping_cart`
--
ALTER TABLE `tbl_shopping_cart`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_site_music`
--
ALTER TABLE `tbl_site_music`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=114;
--
-- AUTO_INCREMENT for table `tbl_talents`
--
ALTER TABLE `tbl_talents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `tbl_talent_payment_method`
--
ALTER TABLE `tbl_talent_payment_method`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `tbl_user_activity`
--
ALTER TABLE `tbl_user_activity`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=149;
--
-- AUTO_INCREMENT for table `tbl_user_details`
--
ALTER TABLE `tbl_user_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tbl_user_profile_settings`
--
ALTER TABLE `tbl_user_profile_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
