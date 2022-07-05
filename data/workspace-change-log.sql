-- when we make a change to the schema or add something to the database
-- we record the SQL here with date and time added for the benefit of other developers and the deployment team

ALTER TABLE `workspace_WorkspaceRoom` ADD COLUMN `roomFeatured` INT NOT NULL AFTER `roomPublished`;
ALTER TABLE `workspace_WorkspaceRoom` ADD COLUMN `roomBookingURL` varchar(255) NOT NULL AFTER `roomURL`;

CREATE TABLE `workspace_Block` (
    `blockID` int NOT NULL AUTO_INCREMENT,
    `siteID` int NOT NULL,
    `creator` int NOT NULL,
    `created` datetime NOT NULL,
    `updated` datetime NULL,
    `deleted` int NOT NULL,
    `blockTitle` varchar(100) NOT NULL,
    `blockText` text NULL,
    `blockLinkURL` varchar(255) NOT NULL,
    `blockPublished` int NOT NULL,
    `blockDisplayOrder` int NOT NULL,
    PRIMARY KEY (`blockID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `workspace_Block`
CHANGE COLUMN `blockTitle` `blockTitleEnglish` VARCHAR(100) NOT NULL ,
CHANGE COLUMN `blockText` `blockTextEnglish` TEXT NOT NULL ,
ADD COLUMN `blockTitleJapanese` VARCHAR(100) NOT NULL AFTER `blockTextEnglish`,
ADD COLUMN `blockTextJapanese` TEXT NOT NULL AFTER `blockTitleJapanese`;

