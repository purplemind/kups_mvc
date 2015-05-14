-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2015 at 08:56 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kups`
--

-- --------------------------------------------------------

--
-- Table structure for table `faulovi`
--

CREATE TABLE IF NOT EXISTS `faulovi` (
  `sifra_faula` varchar(7) NOT NULL,
  `naziv_faula` varchar(50) NOT NULL,
  PRIMARY KEY (`sifra_faula`),
  UNIQUE KEY `sifra_faula_UNIQUE` (`sifra_faula`),
  UNIQUE KEY `naziv_faula_UNIQUE` (`naziv_faula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spisak svih faulova';

--
-- Dumping data for table `faulovi`
--

INSERT INTO `faulovi` (`sifra_faula`, `naziv_faula`) VALUES
('DOD', 'Delay of game, defense\n'),
('DOG', 'Delay of game, offense\n'),
('DSQ', 'Disqualification\n'),
('ENC', 'Encroachment (offense)\n'),
('EQV', 'Equipment violation\n'),
('FST', 'False start\n'),
('FGT', 'Fighting\n'),
('FBG', 'Fighting before game\n'),
('FFH', 'Fighting, first half\n'),
('FHT', 'Fighting, half-time\n'),
('FSH', 'Fighting, second half\n'),
('KOB', 'Free kick out of bounds\n'),
('DH', 'Holding, defense\n'),
('OH', 'Holding, offense\n'),
('BAT', 'Illegal batting\n'),
('IBB', 'Illegal block in the back\n'),
('ILF', 'Illegal formation\n'),
('IFP', 'Illegal forward pass\n'),
('IFK', 'Illegal free kick formation\n'),
('KIK', 'Illegal kick\n'),
('ILM', 'Illegal motion\n'),
('ILP', 'Illegal participation\n'),
('ISH', 'Illegal shift\n'),
('ISP', 'Illegal snap\n'),
('ILS', 'Illegal substitution\n'),
('ITP', 'Illegal touching of a forward pass\n'),
('IKB', 'Illegally kicking ball\n'),
('IDP', 'Ineligible downfield on pass\n'),
('ING', 'Intentional grounding\n'),
('INL', 'Interlockin legs\n'),
('KCI', 'Kickcatch interference\n'),
('DOF', 'Offside, defense\n'),
('OFK', 'Offside, kicking team\n'),
('DPI', 'Pass interference, defense\n'),
('OPI', 'Pass interference, offense\n'),
('BBW/PF', 'Personal foul, blocking below the waist\n'),
('BTH/PF', 'Personal foul, blow to the head\n'),
('BUT/PF', 'Personal foul, butting/ramming with helmet\n'),
('CHB/PF', 'Personal foul, chop block\n'),
('CLP/PF', 'Personal foul, clipping\n'),
('FMM/PF', 'Personal foul, face mask, 15 yards\n'),
('HTF/PF', 'Personal foul, hands to the face\n'),
('HDR/PF', 'Personal foul, hit on defenceless receiver\n'),
('HCT/PF', 'Personal foul, horse collar tackle\n'),
('HUR/PF', 'Personal foul, hurdling\n'),
('ICS/PF', 'Personal foul, illegal contact with snapper\n'),
('ICB/PF', 'Personal foul, illegal crackback\n'),
('LTO/PF', 'Personal foul, late hit out of bounds\n'),
('LTP/PF', 'Personal foul, late hit/piling on\n'),
('LEA/PF', 'Personal foul, leaping\n'),
('LEV/PF', 'Personal foul, leverage\n'),
('UNR/PF', 'Personal foul, other unnecessary roughness\n'),
('RFK/PF', 'Personal foul, roughing free kicker\n'),
('RRK/PF', 'Personal foul, roughing the kicker/holder\n'),
('RPS/PF', 'Personal foul, roughing the passer\n'),
('SKE/PF', 'Personal foul, striking/kneeing/elbowing\n'),
('TRP/PF', 'Personal foul, tripping\n'),
('RNH', 'Running into the kicker/holder\n'),
('SLM', 'Sideline interference, 15 yards\n'),
('SLI', 'Sideline interference, 5 yards\n'),
('UFT', 'Unfair tactics\n'),
('ABL/UC', 'Unsportsmanlike act, abusive language\n'),
('BCH/UC', 'Unsportsmanlike act, bench\n'),
('DEA/UC', 'Unsportsmanlike act, delayed/excessive act\n'),
('UNS/UC', 'Unsportsmanlike act, other\n'),
('RHT/UC', 'Unsportsmanlike act, removal of helmet\n'),
('STB/UC', 'Unsportsmanlike act, spiking/throwing ball\n'),
('TAU/UC', 'Unsportsmanlike act, taunting/baiting\n');

-- --------------------------------------------------------

--
-- Table structure for table `klinike`
--

CREATE TABLE IF NOT EXISTS `klinike` (
  `sifra_klinike` varchar(9) NOT NULL,
  `godina_sezone` smallint(6) NOT NULL,
  `naziv_klinike` varchar(45) NOT NULL,
  PRIMARY KEY (`sifra_klinike`),
  UNIQUE KEY `naziv_klinike_UNIQUE` (`sifra_klinike`),
  KEY `fk_sezona_idx` (`godina_sezone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Prisustvo sudija na klinikama';

-- --------------------------------------------------------

--
-- Table structure for table `klubovi`
--

CREATE TABLE IF NOT EXISTS `klubovi` (
  `sifra_kluba` varchar(5) NOT NULL,
  `naziv_kluba` varchar(50) NOT NULL,
  `sifra_lige` varchar(5) NOT NULL,
  PRIMARY KEY (`sifra_kluba`),
  UNIQUE KEY `sifra_kluba_UNIQUE` (`sifra_kluba`),
  KEY `fk_liga_idx` (`sifra_lige`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spisak svih klubova';

--
-- Dumping data for table `klubovi`
--

INSERT INTO `klubovi` (`sifra_kluba`, `naziv_kluba`, `sifra_lige`) VALUES
('AWCA', 'Angel Warriors Čačak', 'PLS'),
('BDBG', 'Blue Dragons Beograd', 'DLS'),
('BEASO', 'Bears Sofija', 'TLS'),
('BHJA', 'Black Hornets Jagodina', 'TLS'),
('CELSO', 'Sombor Celtis', 'TLS'),
('GATNS', 'GAT Dukes Novi Sad', 'PLS'),
('GBBO', 'Golden Bears Bor', 'DLS'),
('HAWOB', 'Hawks Obrenovac', 'TLS'),
('IMPNI', 'Imperatori Niš', 'PLS'),
('INDIN', 'Indians Inđija', 'PLS'),
('KNIKL', 'Knights Klek', 'TLS'),
('LAVVR', 'Lavovi Vršac', 'DLS'),
('LEGSM', 'Legionaries S. Mitrovica', 'PLS'),
('MAMKI', 'Mamuti Kikinda', 'DLS'),
('PANPA', 'Panthers Pančevo', 'PLS'),
('PASPO', 'Pastuvi Požarevac', 'DLS'),
('PIRZE', 'Pirates Zemun', 'DLS'),
('SHASA', 'Sharks Šabac', 'TLS'),
('VUKBG', 'Vukovi Beograd', 'PLS'),
('WBKG', 'Wild Boars Kragujevac', 'PLS');

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE IF NOT EXISTS `komentari` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `godina_sezone` smallint(6) NOT NULL,
  `autor_komentara` varchar(25) NOT NULL,
  `sifra_sudije` varchar(6) NOT NULL,
  `komentar` text NOT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `fk_sezona_idx` (`godina_sezone`),
  KEY `fk_sudija_idx` (`sifra_sudije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Komentari komesara i disciplinske komisije' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lige`
--

CREATE TABLE IF NOT EXISTS `lige` (
  `sifra_lige` varchar(5) NOT NULL,
  `naziv_lige` varchar(50) NOT NULL,
  PRIMARY KEY (`sifra_lige`),
  UNIQUE KEY `sifra_lige_UNIQUE` (`sifra_lige`),
  UNIQUE KEY `naziv_lige_UNIQUE` (`naziv_lige`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spisak svih liga u SAAF-u';

--
-- Dumping data for table `lige`
--

INSERT INTO `lige` (`sifra_lige`, `naziv_lige`) VALUES
('AAFL', 'Alpe Adria Football League'),
('CEFL', 'Central European Football League'),
('DLS', 'Druga liga Srbije'),
('FLEG', 'Fleg liga'),
('IFAF', 'International Federation of American Football'),
('ITA', 'Italijanska liga'),
('JNR', 'Juniorska liga'),
('PLS', 'Prva liga Srbije'),
('TLS', 'Treća Liga Srbije');

-- --------------------------------------------------------

--
-- Table structure for table `poeni_na_testu`
--

CREATE TABLE IF NOT EXISTS `poeni_na_testu` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `godina_sezone` smallint(6) NOT NULL,
  `sifra_sudije` varchar(6) NOT NULL,
  `broj_poena` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`auto_id`),
  KEY `fk_sudija_idx` (`sifra_sudije`),
  KEY `fk_poeni_sezona` (`godina_sezone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spisak sudija sa ponima ostvarenim na testiranju' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pregledanje_prekrsaja`
--

CREATE TABLE IF NOT EXISTS `pregledanje_prekrsaja` (
  `id_prekrsaja` int(11) NOT NULL,
  `ocena_prekrsaja` enum('CC','MC','BC','NC','NG','CJ/IJ','GM/BM','NR') NOT NULL,
  PRIMARY KEY (`id_prekrsaja`),
  UNIQUE KEY `id_prekrsaja_UNIQUE` (`id_prekrsaja`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prekrsaji_utakmice`
--

CREATE TABLE IF NOT EXISTS `prekrsaji_utakmice` (
  `id_prekrsaja` int(11) NOT NULL AUTO_INCREMENT,
  `sifra_utakmice` int(11) NOT NULL,
  `period` enum('1st','2nd','3rd','4th','ot') NOT NULL,
  `vreme_u_periodu` varchar(10) NOT NULL COMMENT 'Vreme kada se desio prekrsaj u odabranom periodu.',
  `sifra_kluba` varchar(5) NOT NULL,
  `sifra_faula` varchar(7) NOT NULL,
  `uloga_kluba` enum('off','def','kick','rcv') NOT NULL,
  `broj_na_dresu` tinyint(4) NOT NULL,
  `prihvacen` enum('ACCEPT','DECLINE','OFFSET') NOT NULL,
  `pozicija_sudije` enum('R','U','HL','LJ','SJ','FJ','BJ') NOT NULL,
  PRIMARY KEY (`id_prekrsaja`),
  KEY `fk_utakmica_idx` (`sifra_utakmice`),
  KEY `fk_klub_idx` (`sifra_kluba`),
  KEY `fk_faul_idx` (`sifra_faula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prisustvo_na_klinici`
--

CREATE TABLE IF NOT EXISTS `prisustvo_na_klinici` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `sifra_klinike` varchar(9) NOT NULL,
  `sifra_sudije` varchar(6) NOT NULL,
  PRIMARY KEY (`auto_id`),
  KEY `fk_klinika_idx` (`sifra_klinike`),
  KEY `fk_sudija_idx` (`sifra_sudije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Podaci o odrzanim klinikama' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sezona`
--

CREATE TABLE IF NOT EXISTS `sezona` (
  `godina_sezone` smallint(6) NOT NULL,
  `naziv_sezone` varchar(30) NOT NULL,
  PRIMARY KEY (`godina_sezone`),
  UNIQUE KEY `godina_sezone_UNIQUE` (`godina_sezone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Spisak svih sezona';

--
-- Dumping data for table `sezona`
--

INSERT INTO `sezona` (`godina_sezone`, `naziv_sezone`) VALUES
(2015, 'Prva');

-- --------------------------------------------------------

--
-- Table structure for table `sudije`
--

CREATE TABLE IF NOT EXISTS `sudije` (
  `sifra_sudije` varchar(6) NOT NULL,
  `ime` varchar(15) NOT NULL,
  `prezime` varchar(20) NOT NULL,
  `godina_pocetka` int(11) NOT NULL,
  `mesto_stanovanja` varchar(40) NOT NULL,
  `automobil` tinyint(1) NOT NULL,
  `ne_ekipama` text,
  `ne_ligama` text,
  `za_komesara` mediumtext,
  PRIMARY KEY (`sifra_sudije`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Podaci o utakmicama';

--
-- Dumping data for table `sudije`
--

INSERT INTO `sudije` (`sifra_sudije`, `ime`, `prezime`, `godina_pocetka`, `mesto_stanovanja`, `automobil`, `ne_ekipama`, `ne_ligama`, `za_komesara`) VALUES
('dmilos', 'Dragan', 'MiloÅ¡eviÄ‡', 2015, 'Velika Plana', 1, '', 'PLS', '');

-- --------------------------------------------------------

--
-- Table structure for table `utakmice`
--

CREATE TABLE IF NOT EXISTS `utakmice` (
  `sifra_utakmice` int(11) NOT NULL AUTO_INCREMENT,
  `godina_sezone` smallint(6) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vreme_pocetka` varchar(15) NOT NULL,
  `sifra_lige` varchar(5) NOT NULL,
  `domacin` varchar(5) NOT NULL,
  `gost` varchar(5) NOT NULL,
  `domacin_ht_golova` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'HT - half time',
  `gost_ht_golova` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'HT - half time',
  `domacin_ft_golova` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'FT - full time',
  `gost_ft_golova` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'FT - full time',
  `trajanje` varchar(15) NOT NULL COMMENT 'Trajanje utakmice',
  `broj_ot` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'OT - overtime',
  `trajanje_ot_sek` int(11) NOT NULL DEFAULT '0' COMMENT 'OT - overtime',
  `trazi_se_pregled` tinyint(1) NOT NULL DEFAULT '0',
  `pregledana` enum('cela','delimicno','nije') NOT NULL DEFAULT 'nije',
  `sudija_R` varchar(6) NOT NULL,
  `sudija_U` varchar(6) NOT NULL,
  `sudija_HL` varchar(6) NOT NULL,
  `sudija_LJ` varchar(6) NOT NULL,
  `sudija_SJ` varchar(6) NOT NULL,
  `sudija_FJ` varchar(6) NOT NULL,
  `sudija_BJ` varchar(6) NOT NULL,
  PRIMARY KEY (`sifra_utakmice`),
  KEY `fk_liga_idx` (`sifra_lige`),
  KEY `fk_sezona_idx` (`godina_sezone`),
  KEY `fk_domacin_idx` (`domacin`),
  KEY `fk_sudija_R_idx` (`sudija_R`),
  KEY `fk_utakmice_sudija_U_idx` (`sudija_U`),
  KEY `fk_utakmice_sudija_HL_idx` (`sudija_HL`),
  KEY `fk_utakmice_sudija_LJ_idx` (`sudija_LJ`),
  KEY `fk_utakmice_sudija_SJ_idx` (`sudija_SJ`),
  KEY `fk_utakmice_sudija_FJ_idx` (`sudija_FJ`),
  KEY `fk_utakmice_sudija_BJ_idx` (`sudija_BJ`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Podaci o utakmicama' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `klinike`
--
ALTER TABLE `klinike`
  ADD CONSTRAINT `fk_klinike_sezona` FOREIGN KEY (`godina_sezone`) REFERENCES `sezona` (`godina_sezone`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `klubovi`
--
ALTER TABLE `klubovi`
  ADD CONSTRAINT `fk_klubovi_liga` FOREIGN KEY (`sifra_lige`) REFERENCES `lige` (`sifra_lige`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `fk_komentari_sezona` FOREIGN KEY (`godina_sezone`) REFERENCES `sezona` (`godina_sezone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_komentari_sudija` FOREIGN KEY (`sifra_sudije`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poeni_na_testu`
--
ALTER TABLE `poeni_na_testu`
  ADD CONSTRAINT `fk_poeni_sezona` FOREIGN KEY (`godina_sezone`) REFERENCES `sezona` (`godina_sezone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_poeni_sudija` FOREIGN KEY (`sifra_sudije`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pregledanje_prekrsaja`
--
ALTER TABLE `pregledanje_prekrsaja`
  ADD CONSTRAINT `fk_pregledanje_id_prekrsaja` FOREIGN KEY (`id_prekrsaja`) REFERENCES `prekrsaji_utakmice` (`id_prekrsaja`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prekrsaji_utakmice`
--
ALTER TABLE `prekrsaji_utakmice`
  ADD CONSTRAINT `fk_prekrsaji_faul` FOREIGN KEY (`sifra_faula`) REFERENCES `faulovi` (`sifra_faula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prekrsaji_klub` FOREIGN KEY (`sifra_kluba`) REFERENCES `klubovi` (`sifra_kluba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prekrsaji_utakmica` FOREIGN KEY (`sifra_utakmice`) REFERENCES `utakmice` (`sifra_utakmice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prisustvo_na_klinici`
--
ALTER TABLE `prisustvo_na_klinici`
  ADD CONSTRAINT `fk_prisustvo_klinika` FOREIGN KEY (`sifra_klinike`) REFERENCES `klinike` (`sifra_klinike`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_prisustvo_sudija` FOREIGN KEY (`sifra_sudije`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `utakmice`
--
ALTER TABLE `utakmice`
  ADD CONSTRAINT `fk_utakmice_domacin` FOREIGN KEY (`domacin`) REFERENCES `klubovi` (`sifra_kluba`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_liga` FOREIGN KEY (`sifra_lige`) REFERENCES `lige` (`sifra_lige`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sezona` FOREIGN KEY (`godina_sezone`) REFERENCES `sezona` (`godina_sezone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_BJ` FOREIGN KEY (`sudija_BJ`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_FJ` FOREIGN KEY (`sudija_FJ`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_HL` FOREIGN KEY (`sudija_HL`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_LJ` FOREIGN KEY (`sudija_LJ`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_R` FOREIGN KEY (`sudija_R`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_SJ` FOREIGN KEY (`sudija_SJ`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utakmice_sudija_U` FOREIGN KEY (`sudija_U`) REFERENCES `sudije` (`sifra_sudije`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
