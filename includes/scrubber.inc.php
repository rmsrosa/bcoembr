<?php 

/*
Checked Single
2016-06-06
*/

// ---------------------------- Scrubber --------------------------------------------------------------------
$string = array( 
chr(38) => "&#38;", 
chr(60) => "&#60;", 
chr(62) => "&#62;", 
chr(34) => "&#34;", 
chr(35) => "&#35;", 
chr(39) => "&#39;",
chr(176) => "&#176;"
);

$quote_convert = array(
chr(34) => "&quot;",
chr(39) => "&rsquo;",
"&#39;" => "&rsquo;",
"&apos;" => "&rsquo;",
"“" => "&ldquo;",   // left side double smart quote
"”" => "&rdquo;",  	// right side double smart quote
"‘" => "&lsquo;",  	// left side single smart quote
"’" => "&rsquo;", 	// right side single smart quote
"…" => "...",  		// elipsis
"—" => "&mdash;",  	// em dash
"–" => "&ndash;",  	// en dash
"\n" => " ",
"\t" => " ",
);

$html_string = array( 
/*
chr(34) => "&quot;",  
chr(37) => "&#37;",
chr(38) => "&amp;",
chr(39) => "&rsquo;", 
chr(60) => "&lt;", 
chr(62) => "&gt;", 
chr(161) => "&iexcl;",
chr(162) => "&cent;",
chr(163) => "&pound;",
chr(164) => "&curren;",
chr(165) => "&yen;",
chr(168) => "&uml;",
chr(169) => "&copy;",
chr(171) => "&laquo;",
chr(174) => "&reg;",
chr(176) => "&deg;",
chr(188) => "&#188;",
chr(189) => "&#189;",
chr(190) => "&#190;",
chr(192) => "&#191;",
chr(224) => "&#224;",
chr(193) => "&#193;",
chr(225) => "&#225;",
chr(194) => "&#194;",
chr(226) => "&#226;",
chr(195) => "&#195;",
chr(227) => "&#227;",
chr(196) => "&#196;",
chr(228) => "&#228;",
chr(197) => "&#197;",
chr(229) => "&#229;",
chr(256) => "&#256;",
chr(257) => "&#257;",
chr(258) => "&#258;",
chr(259) => "&#259;",
chr(260) => "&#260;",
chr(261) => "&#261;",
chr(478) => "&#478;",
chr(479) => "&#479;",
chr(506) => "&#506;",
chr(507) => "&#507;",
chr(198) => "&#198;",
chr(230) => "&#230;",
chr(508) => "&#508;",
chr(509) => "&#509;",
chr(7682) => "&#7682;",
chr(7683) => "&#7683;",
chr(262) => "&#262;",
chr(263) => "&#263;",
chr(199) => "&#199;",
chr(231) => "&#231;",
chr(268) => "&#268;",
chr(269) => "&#269;",
chr(264) => "&#264;",
chr(265) => "&#265;",
chr(266) => "&#266;",
chr(267) => "&#267;",
chr(7696) => "&#7696;",
chr(7697) => "&#7697;",
chr(270) => "&#270;",
chr(271) => "&#271;",
chr(7690) => "&#7690;",
chr(7691) => "&#7691;",
chr(272) => "&#272;",
chr(273) => "&#273;",
chr(208) => "&#208;",
chr(240) => "&#240;",
chr(497) => "&#497;",
chr(499) => "&#499;",
chr(452) => "&#452;",
chr(454) => "&#454;",
chr(200) => "&#200;",
chr(232) => "&#232;",
chr(201) => "&#201;",
chr(233) => "&#233;",
chr(282) => "&#282;",
chr(283) => "&#283;",
chr(202) => "&#202;",
chr(234) => "&#234;",
chr(203) => "&#203;",
chr(235) => "&#235;",
chr(274) => "&#274;",
chr(275) => "&#275;",
chr(276) => "&#276;",
chr(277) => "&#277;",
chr(280) => "&#280;",
chr(281) => "&#281;",
chr(278) => "&#278;",
chr(279) => "&#279;",
chr(439) => "&#439;",
chr(658) => "&#658;",
chr(494) => "&#494;",
chr(495) => "&#495;",
chr(7710) => "&#7710;",
chr(7711) => "&#7711;",
chr(402) => "&#402;",
chr(64256) => "&#64256;",
chr(64257) => "&#64257;",
chr(64258) => "&#64258;",
chr(64259) => "&#64259;",
chr(64260) => "&#64260;",
chr(64261) => "&#64261;",
chr(500) => "&#500;",
chr(501) => "&#501;",
chr(290) => "&#290;",
chr(291) => "&#291;",
chr(486) => "&#486;",
chr(487) => "&#487;",
chr(284) => "&#284;",
chr(285) => "&#285;",
chr(286) => "&#286;",
chr(287) => "&#287;",
chr(288) => "&#288;",
chr(289) => "&#289;",
chr(484) => "&#484;",
chr(485) => "&#485;",
chr(292) => "&#292;",
chr(293) => "&#293;",
chr(294) => "&#294;",
chr(295) => "&#295;",
chr(204) => "&#204;",
chr(236) => "&#236;",
chr(205) => "&#205;",
chr(237) => "&#237;",
chr(206) => "&#206;",
chr(238) => "&#238;",
chr(296) => "&#296;",
chr(297) => "&#297;",
chr(207) => "&#207;",
chr(239) => "&#239;",
chr(298) => "&#298;",
chr(299) => "&#299;",
chr(300) => "&#300;",
chr(301) => "&#301;",
chr(302) => "&#302;",
chr(303) => "&#303;",
chr(304) => "&#304;",
chr(305) => "&#305;",
chr(306) => "&#306;",
chr(307) => "&#307;",
chr(308) => "&#308;",
chr(309) => "&#309;",
chr(7728) => "&#7728;",
chr(7729) => "&#7729;",
chr(310) => "&#310;",
chr(311) => "&#311;",
chr(488) => "&#488;",
chr(489) => "&#489;",
chr(312) => "&#312;",
chr(313) => "&#313;",
chr(314) => "&#314;",
chr(315) => "&#315;",
chr(316) => "&#316;",
chr(317) => "&#317;",
chr(318) => "&#318;",
chr(319) => "&#319;",
chr(320) => "&#320;",
chr(321) => "&#321;",
chr(322) => "&#322;",
chr(455) => "&#455;",
chr(457) => "&#457;",
chr(7744) => "&#7744;",
chr(7745) => "&#7745;",
chr(323) => "&#323;",
chr(324) => "&#324;",
chr(325) => "&#325;",
chr(326) => "&#326;",
chr(327) => "&#327;",
chr(328) => "&#328;",
chr(209) => "&#209;",
chr(241) => "&#241;",
chr(329) => "&#329;",
chr(330) => "&#330;",
chr(331) => "&#331;",
chr(458) => "&#458;",
chr(460) => "&#460;",
chr(210) => "&#210;",
chr(242) => "&#242;",
chr(211) => "&#211;",
chr(243) => "&#243;",
chr(212) => "&#212;",
chr(244) => "&#244;",
chr(213) => "&#213;",
chr(245) => "&#245;",
chr(214) => "&#214;",
chr(246) => "&#246;",
chr(332) => "&#332;",
chr(333) => "&#333;",
chr(334) => "&#334;",
chr(335) => "&#335;",
chr(216) => "&#216;",
chr(248) => "&#248;",
chr(336) => "&#336;",
chr(337) => "&#337;",
chr(510) => "&#510;",
chr(511) => "&#511;",
chr(338) => "&#338;",
chr(339) => "&#339;",
chr(7766) => "&#7766;",
chr(7767) => "&#7767;",
chr(340) => "&#340;",
chr(341) => "&#341;",
chr(342) => "&#342;",
chr(343) => "&#343;",
chr(344) => "&#344;",
chr(345) => "&#345;",
chr(636) => "&#636;",
chr(346) => "&#346;",
chr(347) => "&#347;",
chr(350) => "&#350;",
chr(351) => "&#351;",
chr(352) => "&#352;",
chr(353) => "&#353;",
chr(348) => "&#348;",
chr(349) => "&#349;",
chr(7776) => "&#7776;",
chr(7777) => "&#7777;",
chr(383) => "&#383;",
chr(223) => "&#223;", 
chr(354) => "&#354;",
chr(355) => "&#355;",
chr(356) => "&#356;",
chr(357) => "&#357;",
chr(7786) => "&#7786;",
chr(7787) => "&#7787;",
chr(358) => "&#358;",
chr(359) => "&#359;",
chr(222) => "&#222;",
chr(254) => "&#254;",
chr(217) => "&#217;",
chr(249) => "&#249;",
chr(218) => "&#218;",
chr(250) => "&#250;",
chr(219) => "&#219;",
chr(251) => "&#251;",
chr(360) => "&#360;",
chr(361) => "&#361;",
chr(220) => "&#220;",
chr(252) => "&#252;",
chr(336) => "&#366;",
chr(367) => "&#367;",
chr(362) => "&#362;",
chr(363) => "&#363;",
chr(364) => "&#364;",
chr(365) => "&#365;",
chr(370) => "&#370;",
chr(371) => "&#371;",
chr(368) => "&#368;",
chr(369) => "&#369;",
chr(7708) => "&#7808;",
chr(7809) => "&#7809;",
chr(7810) => "&#7810;",
chr(7811) => "&#7811;",
chr(372) => "&#372;",
chr(373) => "&#373;",
chr(7812) => "&#7812;",
chr(7813) => "&#7813;",
chr(7922) => "&#7922;",
chr(7923) => "&#7923;",
chr(221) => "&#221;",
chr(253) => "&#253;",
chr(374) => "&#374;",
chr(375) => "&#375;",
chr(159) => "&#159;",
chr(255) => "&#255;",
chr(377) => "&#377;",
chr(378) => "&#378;",
chr(381) => "&#381;",
chr(382) => "&#382;",
chr(379) => "&#379;",
chr(380) => "&#380;",
*/
"&#39;" => "&rsquo;",
"&apos;" => "&rsquo;",
"“" => "&ldquo;",   // left side double smart quote
"”" => "&rdquo;",  	// right side double smart quote
"‘" => "&lsquo;",  	// left side single smart quote
"’" => "&rsquo;",  	// right side single smart quote
"…" => "...",  		// elipsis
"—" => "&mdash;",  	// em dash
"–" => "&ndash;",  	// en dash
);
$html_remove = array( 
"&amp;" => "&",
"&lt;" => "<", 
"&gt;" => ">", 
"&quot;" => "\"", 
"&rsquo;" => "'",
"&rdquo;" => "\"",
"&ldquo;" => "\"",
"&lsquo;" => "'",
"&#39;" => "\"",
"&#37;" => "%",
"&deg;" => "",
"&copy;" => "",
"&reg;" => "",
"<p>" => "",
"^" => " ", 		// used in process_brewing.inc.php to separate extra requirements for BJCP 2015 styles
"“" => "\"",   	// left side double smart quote
"”" => "\"",  	// right side double smart quote
"‘" => "'",  	// left side single smart quote
"’" => "'",  	// right side single smart quote
"…" => "...",  	// elipsis
"—" => "--",  	// em dash
"–" => "-",  	// en dash
);
$space_remove = array( 
"&amp;" => "",
"&lt;" => "", 
"&gt;" => "", 
"&quot;" => "", 
"&rsquo;" => "",
"&#39;" => "",
"&deg;" => "",
" " => "",
"&nbsp;" => ""
);
$bjcp_num_replace = array( 
"(" => "9", 
")" => "0", 
"o" => "0", 
"O" => "0",
"-" => ""
);
?>