DROP TABLE	wcf1_woltlab_pluginstore_file_content_provider_mapping;
CREATE TABLE	wcf1_woltlab_pluginstore_file_content_provider_mapping (
	fileID				INT(10) NOT NULL,
	contentProviderObjectTypeID	INT(10) DEFAULT NULL,
	objectID			INT(10) NOT NULL,
	
	UNIQUE KEY (fileID)
);

ALTER TABLE wcf1_woltlab_pluginstore_file_content_provider_mapping ADD FOREIGN KEY (fileID) REFERENCES wcf1_woltlab_pluginstore_file (fileID) ON DELETE CASCADE;
ALTER TABLE wcf1_woltlab_pluginstore_file_content_provider_mapping ADD FOREIGN KEY (contentProviderObjectTypeID) REFERENCES wcf1_object_type (objectTypeID) ON DELETE SET NULL;