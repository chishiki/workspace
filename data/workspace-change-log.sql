-- when we make a change to the schema or add something to the database
-- we record the SQL here with date and time added for the benefit of other developers and the deployment team

ALTER TABLE `workspace_WorkspaceRoom` ADD COLUMN `roomFeatured` INT NOT NULL AFTER `roomPublished`;
ALTER TABLE `workspace_WorkspaceRoom` ADD COLUMN `roomBookingURL` varchar(255) NOT NULL AFTER `roomURL`;
