INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Москва'),
(2, 'Санкт-Петурбург');

INSERT INTO `mark` (`id`, `name`) VALUES
(1, 'ТАГАЗ'),
(2, 'BMW'),
(3, 'Brilliance'),
(4, 'BYD'),
(5, 'Changan'),
(6, 'Chery'),
(7, 'Chevrolet'),
(8, 'Citroen'),
(10, 'Dongfeng'),
(11, 'FAW'),
(12, 'Ford'),
(13, 'Geely'),
(14, 'Great Wall'),
(15, 'Haima'),
(16, 'Haval'),
(17, 'Hyundai'),
(18, 'Infiniti'),
(19, 'JAC'),
(20, 'Kia'),
(21, 'Lada'),
(22, 'Lifan'),
(23, 'Mazda'),
(24, 'Luxgen'),
(26, 'Mitsubishi'),
(27, 'Nissan'),
(28, 'Opel'),
(29, 'Peugeot'),
(31, 'Ravon'),
(32, 'Renault'),
(33, 'Skoda'),
(34, 'Ssangyong'),
(35, 'Suzuki'),
(37, 'Toyota'),
(38, 'Volkswagen'),
(39, 'Zotye'),
(40, 'FIAT'),
(41, 'DW Hower'),
(42, 'Hawtai Motor'),
(43, 'Honda'),
(44, 'dfffffffffff'),
(45, 'UAZ'),
(46, 'Foton'),
(47, 'Hyundai');

INSERT INTO `model` (`id`, `name`, `mark_id`) VALUES
(1, '1 серии', 2),
(4, 'H230 sedan', 3),
(6, 'V3', 3),
(7, 'V5', 3),
(9, 'F3', 4),
(10, 'CS35', 5),
(11, 'CS75', 5),
(12, 'Eado XT', 5),
(13, 'Eado', 5),
(14, 'Raeton', 5),
(15, 'Benni', 5),
(16, 'CS15', 5),
(17, 'CS95', 5),
(19, 'CX70', 5),
(21, 'Arrizo', 6),
(22, 'M11 sedan', 6),
(23, 'tiggo 5 new', 6),
(24, 'M11 hatch', 6),
(26, 'indis', 6),
(28, 'tiggo 5', 6),
(29, 'Very', 6),
(30, 'bonus', 6),
(31, 'Tiggo 2', 6),
(32, 'bonus 3', 6),
(33, 'Tiggo 3', 6),
(34, 'Cruze sedan', 7),
(35, 'Cobalt', 7),
(36, 'Aveo hatch', 7),
(37, 'Aveo sedan', 7),
(38, 'niva', 7),
(39, 'Cruze sw', 7),
(42, 'Tracker', 7),
(43, 'Cruze hatch', 7),
(44, 'Orlando', 7),
(45, 'Spark', 7),
(46, 'Tahoe new', 7),
(47, 'Captiva', 7),
(48, 'Camaro', 7),
(49, 'Tahoe', 7),
(50, 'Trailblazer', 7),
(51, 'Trailblazer', 7),
(52, 'C3 picasso', 8),
(53, 'C5 Tourer', 8),
(54, 'C-Elysee', 8),
(55, 'C4 sedan', 8),
(56, 'C4 Aircross', 8),
(57, 'C4 sedan new', 8),
(58, 'C4', 8),
(59, 'C1', 8),
(60, 'DS3', 8),
(61, 'Berlingo', 8),
(62, 'C4 Grand Picasso', 8),
(63, 'Berlingo Multispace', 8),
(64, 'Berlingo Multispace New', 8),
(65, 'DS4', 8),
(66, 'C4 picasso', 8),
(69, 'H30 Cross', 10),
(70, 'S30', 10),
(71, 'ax7', 10),
(72, 'Besturn B50', 11),
(73, '2', 11),
(74, '5', 11),
(75, 'Oley', 11),
(76, 'Besturn B70', 11),
(77, 'Besturn X80', 11),
(78, 'ducato комби', 40),
(79, 'scudo van', 40),
(80, 'ducato фургон', 40),
(81, 'ducato шасси', 40),
(82, 'scudo', 40),
(83, 'doblo panorama', 40),
(84, 'Freemont', 40),
(85, '500', 40),
(86, 'Punto 5d', 40),
(87, 'Punto 3d', 40),
(88, 'Mondeo wagon', 12),
(89, 'S-Max', 12),
(90, 'Explorer New', 12),
(91, 'Focus sedan', 12),
(92, 'Focus wag', 12),
(93, 'Focus hatch', 12),
(94, 'Fiesta sedan', 12),
(95, 'Fiesta hatch', 12),
(96, 'mondeo New', 12),
(97, 'mondeo', 12),
(98, 'focus wag new', 12),
(99, 'focus hatch new', 12),
(100, 'focus sedan new', 12),
(101, 'kuga new', 12),
(102, 'kuga', 12),
(103, 'tourneo custom', 12),
(105, 'transit фургон', 12),
(106, 'transit custom фургон', 12),
(107, 'Gradn C-max', 12),
(108, 'NL3', 13),
(109, 'Emgrand GT', 13),
(110, 'Emgrand GC9', 13),
(111, 'Emgrand Cross', 13),
(112, 'MK 08', 13),
(113, 'GC6', 13),
(114, 'emgrand EC7 hatch', 13),
(115, 'emgrand EC7 sedan', 13),
(116, 'emgrand x7 new', 13),
(117, 'emgrand x7', 13),
(119, 'emgrand sedan', 13),
(120, 'emgrand hatch', 13),
(121, 'mk cross', 13),
(122, 'mk', 13),
(123, 'hover m2', 14),
(124, 'hover m1', 14),
(125, 'h5', 14),
(126, 'h3 new', 14),
(127, 'h3', 14),
(128, 'h6 gw', 14),
(129, 'wingle 5', 14),
(130, 'm4', 14),
(131, 'M3', 15),
(132, '3 Hatch Haima', 15),
(134, '7', 15),
(135, 'H6 haval', 16),
(136, 'H2', 16),
(137, 'H8', 16),
(138, 'H9', 16),
(139, 'H7 dw', 41),
(140, 'H6 dw', 41),
(141, 'Boliger', 42),
(142, 'Pilot', 43),
(143, 'CR-V new', 43),
(144, 'Crosstour', 43),
(145, 'CR-V', 43),
(146, 'Civic 5D', 43),
(147, 'Civic 4D', 43),
(148, 'Accord', 43),
(149, 'Equus', 17),
(150, 'IX 55', 17),
(151, 'Porter 2', 17),
(152, 'Genesis', 17),
(153, 'H1', 17),
(154, 'Creta', 17),
(155, 'tucson', 17),
(156, 'Grand Santa Fe', 17),
(157, 'santa fe premium', 17),
(158, 'santa fe', 17),
(159, 'i40 wag', 17),
(160, 'i40 sed', 17),
(161, 'I30 hatch 3d', 17),
(162, 'i30 wagon', 17),
(163, 'i30 хэтчбек 5d new', 17),
(164, 'i30 хэтчбек 5d', 17),
(165, 'elantra new', 17),
(166, 'elantra', 17),
(167, 'solaris sed 2017', 17),
(169, 'QX80', 18),
(170, 'QX70', 18),
(171, 'QX60', 18),
(172, 'QX50', 18),
(173, 'Q70', 18),
(174, 'Q50', 18),
(175, 'J5', 19),
(176, 'S5', 19),
(177, 'optima new', 20),
(180, 'Ceed GT 5d', 20),
(181, 'ceed sw', 20),
(182, 'pro-ceed 3dr', 20),
(183, 'soul', 20),
(185, 'Sorento Prime', 20),
(186, 'sorento', 20),
(188, 'Sportage New', 20),
(190, 'rio sed 2017', 20),
(191, 'rio hatchback', 20),
(192, 'rio sed', 20),
(193, '4x4 urban 3dr', 21),
(194, '4x4 urban 5dr', 21),
(197, 'kalina sport', 21),
(198, 'granta sport', 21),
(199, 'largus cross 7 мест', 21),
(200, 'largus cross 5 мест', 21),
(201, 'largus 7 мест', 21),
(202, 'largus 5 мест', 21),
(203, 'largus фургон', 21),
(204, 'kalina cross', 21),
(205, '4x4 Bronto', 21),
(207, 'Murman', 22),
(209, 'cellya', 22),
(210, 'solano new ll', 22),
(211, 'myway', 22),
(213, 'smily new', 22),
(214, 'cebrium', 22),
(216, 'x60 new', 22),
(217, 'x60', 22),
(218, 'x50', 22),
(221, '3 sedan', 23),
(222, 'cx-9', 23),
(223, 'cx-5 new', 23),
(224, 'cx-5', 23),
(225, '6 sedan new', 23),
(226, '6 sedan', 23),
(228, '2 mazd', 23),
(229, '3 hatch new', 23),
(231, '3 sedan new', 23),
(232, 'Lancer', 26),
(233, 'L200 2014', 26),
(235, 'Outlander New', 26),
(236, 'Pajero Sport new 2017', 26),
(237, 'Pajero Sport', 26),
(238, 'Pajero', 26),
(239, 'L200 new', 26),
(240, 'Outlander', 26),
(242, 'ASX', 26),
(243, 'NP 300 pickup', 27),
(245, 'Navara', 27),
(246, 'GT-R', 27),
(247, 'patrol', 27),
(248, 'Pathfinder', 27),
(249, 'murano', 27),
(250, 'terrano', 27),
(251, 'qashqai new', 27),
(252, 'sentra', 27),
(253, 'almera', 27),
(254, 'Corsa 3d', 28),
(255, 'Meriva', 28),
(256, 'Zafira Tourer', 28),
(257, 'Zafira Family', 28),
(258, 'insignia country tourer', 28),
(259, 'Insignia sports tourer', 28),
(260, 'insignia hatch', 28),
(261, 'Insignia sedan', 28),
(262, 'Astra Sports Tourer', 28),
(263, 'Corsa', 28),
(264, 'Astra sw', 28),
(266, 'Antara', 28),
(267, 'astra sedan', 28),
(268, 'Astra 3dr', 28),
(269, 'astra hatch', 28),
(270, 'Astra family sw', 28),
(271, 'Astra Family sedan', 28),
(272, 'Astra Family Hatch', 28),
(273, 'Astra GTC', 28),
(274, 'Mokka', 28),
(275, 'traveller', 29),
(276, 'Expert', 29),
(277, 'Partner фургон', 29),
(278, '208 3D', 29),
(279, '208', 29),
(280, '2008', 29),
(281, '508', 29),
(282, '4008', 29),
(283, '3008', 29),
(284, '408', 29),
(285, '308', 29),
(286, '301', 29),
(287, '107 5dr', 29),
(288, 'R4', 31),
(289, 'R3', 31),
(290, 'R2', 31),
(291, 'gentra', 31),
(292, 'nexia', 31),
(293, 'matiz', 31),
(294, 'master', 32),
(295, 'master шасси', 32),
(296, 'sandero old', 32),
(297, 'logan old', 32),
(299, 'koleos', 32),
(300, 'fluence', 32),
(301, 'sandero', 32),
(302, 'sandero stepway new', 32),
(303, 'sandero stepway', 32),
(304, 'duster new', 32),
(306, 'Roomster', 33),
(307, 'Kodiaq', 33),
(308, 'suprb combi', 33),
(309, 'Octavia RS', 33),
(310, 'Fabia combi', 33),
(311, 'octavia Combi new 2017', 33),
(312, 'octavia Combi', 33),
(313, 'Fabia', 33),
(314, 'superb', 33),
(315, 'yeti outdoor', 33),
(316, 'yeti', 33),
(317, 'rapid new 2017', 33),
(318, 'rapid', 33),
(319, 'octavia New 2017', 33),
(320, 'octavia', 33),
(321, 'Tivoli', 34),
(322, 'XLV', 34),
(323, 'Actyon sports', 34),
(324, 'Rexton', 34),
(325, 'Stavic', 34),
(326, 'Kyron', 34),
(327, 'Actyon new', 34),
(328, 'Actyon', 34),
(329, 'SX4', 35),
(330, 'Swift 5dr', 35),
(331, 'Swift 3dr', 35),
(332, 'SX4 Sedan', 35),
(333, 'Splash', 35),
(334, 'Jimny', 35),
(335, 'Grand Vitara New', 35),
(336, 'SX4 hatch', 35),
(337, 'SX4 Classic', 35),
(338, 'SX4 new', 35),
(339, 'Grand Vitara 5d', 35),
(340, 'Grand Vitara 3d', 35),
(341, 'Vitara S 1.4Т', 35),
(342, 'Vitara', 35),
(343, 'corolla 2017', 37),
(344, 'Hilux', 37),
(345, 'Verso', 37),
(346, 'Venza', 37),
(347, 'Rav 4 new', 37),
(348, 'Land Cruiser Prado 7 мест', 37),
(349, 'Land Cruiser Prado', 37),
(350, 'Highlander', 37),
(351, 'rav4', 37),
(352, 'corolla', 37),
(353, 'camry', 37),
(355, 'golf 3d', 38),
(356, 'Tiguan new', 38),
(357, 'Touran', 38),
(358, 'polo hatch', 38),
(359, 'beetle', 38),
(360, 'golf gti', 38),
(361, 'Amarok', 38),
(362, 'Passat CC', 38),
(363, 'passat new 2017', 38),
(364, 'alltrack', 38),
(365, 'scirocco', 38),
(366, 'passat', 38),
(367, 'golf', 38),
(368, 'tiguan', 38),
(369, 'jetta', 38),
(370, 'polo sedan new', 38),
(371, 'Z300', 39),
(372, 'T600', 39),
(373, 'Tingo', 1),
(374, 'Estina', 1),
(375, 'Corda', 1),
(376, 'Alsvin V7', 5),
(377, 'ASX New 2017', 26),
(378, 'H3 dw', 41),
(379, 'Koleos new 2017', 32),
(380, 'Priora Sedan', 21),
(381, 'Priora SW', 21),
(383, 'XRay', 21),
(384, 'Vesta', 21),
(385, 'Vesta CNG', 21),
(386, 'Vesta SW Cross', 21),
(387, 'Vesta SW', 21),
(388, 'Granta liftback', 21),
(389, '4x4 5d', 21),
(390, '4x4 3d', 21),
(391, 'Kalina Hatchback', 21),
(393, 'Picanto 5d new 2017', 20),
(394, 'Picanto 5d old', 20),
(395, 'Pro-Ceed GT 3d', 20),
(397, 'Quoris', 20),
(398, 'Mohave', 20),
(400, 'Cerato old', 20),
(401, 'Cerato new 2017', 20),
(402, 'Emgrand 7', 13),
(403, 'Caddy', 38),
(404, 'Ecosport', 12),
(405, 'X-Trail old', 27),
(406, 'X-Trail new', 27),
(407, 'Juke', 27),
(408, 'Juke Old', 27),
(409, 'Logan', 32),
(410, 'Megane coupe', 32),
(411, 'Duster Old', 32),
(412, 'Kaptur', 32),
(413, 'Kangoo', 32),
(414, 'Kangoo фургон', 32),
(416, 'Megane RS', 32),
(417, 'Megane 3d', 32),
(418, 'Ceed 5d', 20),
(419, 'Spacetourer', 8),
(420, 'ix35', 17),
(421, 'Solaris old', 17),
(422, 'Solaris hatchback 2014', 17),
(423, 'Prius', 37),
(424, 'Granta', 21),
(425, 'Kalina Wagon', 21),
(426, 'Rio X-Line', 20),
(427, 'H6 Coupe', 16),
(428, 'Wingle 3', 14),
(429, 'C5', 8),
(430, 'Epica', 7),
(431, 'Lacetti Sedan', 7),
(432, 'Lacetti Hatchback', 7),
(433, 'Lacetti Wagon', 7),
(434, 'Tiida', 27),
(435, 'Teana', 27),
(436, 'Tiggo FL', 6),
(437, 'Megane 5dr', 32),
(438, 'Veloster', 17),
(439, 'Touareg', 38),
(440, 'Patriot Pickup new', 45),
(441, 'Patriot new', 45),
(442, 'Patriot Pickup', 45),
(443, 'Patriot', 45),
(444, 'Hunter', 45),
(445, 'Latitude', 32),
(446, 'Sonata 2017', 17),
(447, 'Outlander GT', 26),
(448, 'Priora Купе', 21),
(449, 'Alphard', 37),
(450, 'Fortuner', 37),
(451, 'Land Cruiser 200', 37),
(452, 'GT-86', 37),
(453, 'Auris', 37),
(454, 'Passat Variant', 38),
(455, 'Passat Alltrack', 38),
(456, 'Golf Plus', 38),
(457, 'Sonata old', 17),
(458, 'Octavia Scout', 33),
(459, 'H530', 3),
(460, 'CX-7', 23),
(461, 'Galaxy', 12),
(462, 'Superb SW', 33),
(463, 'Kimo', 6),
(464, 'CrossEastar', 6),
(465, 'View', 46),
(466, 'Tunland', 46),
(467, 'Sauvana', 46),
(468, '3 Sedan Haima', 15),
(469, 'Partner Tepee', 29),
(470, 'Dokker', 32),
(471, 'h6', 14),
(472, 'Picanto 3d new', 20);

INSERT INTO `shop` (`id`, `city_id`, `name`, `url`, `template`) VALUES
(5, 1, 'Мас Моторс', 'www.masmotors.ru', 'div[class=carprice]'),
(6, 1, 'Центральный', 'www.saloncentr.ru', 'span#discount_price'),
(7, 1, 'Ria Avto', 'http://riaavto.ru/changan/cs35', 'span.foo'),
(13, 1, 'Пилот Авто', 'pilot-auto77.ru', 'div[class=cost] span'),
(14, 1, 'Altera', 'altera-auto.ru', 'span[class=price] span[itemprop=price]'),
(16, 2, 'Гамма Эксперт', 'http://gamma-expert.spb.ru', 'div[class=price] div[class=current]'),
(18, 2, 'Ohta Auto', 'ohta-auto.ru', 'div[class=price] div[class=current]'),
(21, 2, 'Kremlin-auto', 'kremlin-auto.ru', 'td[class=price]'),
(23, 2, 'Askona-motors', 'askona-motors.ru', 'td[class=price]'),
(38, 1, 'cardex.city', 'nissan.cardex.city', 'div[class=price]'),
(41, 1, 'Detroit Avto', 'detroit-avto.com', 'div[class=new] span'),
(42, 1, 'chevrolet. cardex', 'chevrolet.cardex.city', '.price .val'),
(43, 1, 'mitsubishi. cardex', 'mitsubishi.cardex.city', '.price .val'),
(44, 1, 'vita-auto.ru', 'vita-auto.ru', 'td[class=redbray]'),
(45, 1, 'darcars.ru', 'darcars.ru', 'div[class=new] span'),
(47, 1, 'car-giant.ru', 'car-giant.ru', 'div[class=new] span'),
(48, 2, 'auto-ritet.spb.ru', 'auto-ritet.spb.ru', 'div[class=current] span'),
(49, 1, 'ИНКОМ-АВТО', 'www.incom-auto.ru', 'ins'),
(50, 2, 'piter-auto24', 'piter-auto24.ru', 'div[class=price semibold]'),
(51, 1, 'Премикс-Авто', 'premix-auto.ru', 'div[class=current] span'),
(52, 1, 'zilart-auto', 'zilart-auto.ru', 'div[class=price car_item__price] span'),
(53, 1, 'Adom', 'adom.ru', 'div[class=block-hits-item-price]'),
(54, 2, 'Полюстрово автоцентр', 'autocentr-polustrovo.ru', 'div[class=prices]');