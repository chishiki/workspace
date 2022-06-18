
DROP TABLE IF EXISTS `workspace_WorkspaceRoom`;

CREATE TABLE `workspace_WorkspaceRoom` (
    `roomID` int(12) NOT NULL AUTO_INCREMENT,
    `roomCategoryID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `roomNameEnglish` varchar(255) NOT NULL,
    `roomDescriptionEnglish` text NOT NULL,
    `roomNameJapanese` varchar(255) NOT NULL,
    `roomDescriptionJapanese` text NOT NULL,
    `roomPublished` int(1) NOT NULL,
    `roomFeatured` int(1) NOT NULL,
    `roomURL` varchar(100) NOT NULL,
    `roomBookingURL` varchar(255) NOT NULL,
    PRIMARY KEY (`roomID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `workspace_WorkspaceRoomCategory`;

CREATE TABLE `workspace_WorkspaceRoomCategory` (
    `roomCategoryID` int(12) NOT NULL AUTO_INCREMENT,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `roomCategoryNameEnglish` varchar(255) NOT NULL,
    `roomCategoryDescriptionEnglish` text NOT NULL,
    `roomCategoryNameJapanese` varchar(255) NOT NULL,
    `roomCategoryDescriptionJapanese` text NOT NULL,
    `roomCategoryPublished` int(1) NOT NULL,
    `roomCategoryURL` varchar(100) NOT NULL,
    `roomCategoryDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`roomCategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `workspace_WorkspaceRoomSpecification`;

CREATE TABLE `workspace_WorkspaceRoomSpecification` (
    `roomSpecificationID` int(12) NOT NULL AUTO_INCREMENT,
    `roomID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `roomSpecificationNameEnglish` varchar(255) NOT NULL,
    `roomSpecificationDescriptionEnglish` text NOT NULL,
    `roomSpecificationNameJapanese` varchar(255) NOT NULL,
    `roomSpecificationDescriptionJapanese` text NOT NULL,
    `roomSpecificationPublished` int(1) NOT NULL,
    `roomSpecificationDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`roomSpecificationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `workspace_WorkspaceRoomFeature`;

CREATE TABLE `workspace_WorkspaceRoomFeature` (
    `roomFeatureID` int(12) NOT NULL AUTO_INCREMENT,
    `roomID` int(12) NOT NULL,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `roomFeatureNameEnglish` varchar(255) NOT NULL,
    `roomFeatureDescriptionEnglish` text NOT NULL,
    `roomFeatureNameJapanese` varchar(255) NOT NULL,
    `roomFeatureDescriptionJapanese` text NOT NULL,
    `roomFeaturePublished` int(1) NOT NULL,
    `roomFeatureDisplayOrder` int(4) NOT NULL,
    PRIMARY KEY (`roomFeatureID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DROP TABLE IF EXISTS `workspace_WorkspaceNews`;

CREATE TABLE `workspace_WorkspaceNews` (
    `newsID` int(12) NOT NULL AUTO_INCREMENT,
    `siteID` int(12) NOT NULL,
    `creator` int(12) NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NOT NULL,
    `deleted` int(1) NOT NULL,
    `newsDate` date NOT NULL,
    `newsTitleEnglish` varchar(255) NOT NULL,
    `newsContentEnglish` text NOT NULL,
    `newsTitleJapanese` varchar(255) NOT NULL,
    `newsContentJapanese` text NOT NULL,
    `newsPublished` int(1) NOT NULL,
    `newsURL` varchar(100) NOT NULL,
    PRIMARY KEY (`newsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
