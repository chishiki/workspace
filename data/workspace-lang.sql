SET @now := now();

INSERT INTO perihelion_Lang VALUES ('roomCreate', 'Room Create', 0, '製品追加', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCreate', 'Room Create', 0, '製品追加', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomUpdate', 'Room Update', 0, '製品更新', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomUpdate', 'Room Update', 0, '製品更新', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomNameEnglish', 'Room Name (English)', 0, '製品名(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomDescriptionEnglish', 'Description (English)', 0, '詳細(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomNameJapanese', 'Room Name (Japanese)', 0, '製品名(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomDescriptionJapanese', 'Description (Japanese)', 0, '詳細(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('returnToList', 'Return to List', 0, '一覧に戻る', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomList', 'Room List', 0, '製品一覧', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomID', 'ID', 0, 'ID', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomName', 'Room Name', 0, '製品名', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemCreatingYourWorkspaceRoom', 'There was a problem creating your room.', 0, 'エラーが発生して、製品が追加されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemUpdatingYourWorkspaceRoom', 'There was a problem updating your room.', 0, 'エラーが発生して、製品が更新されなかったです', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemDeletingYourWorkspaceRoom', 'There was a problem deleting your room.', 0, 'エラーが発生して、製品が削除されなかったです', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomUpdateSuccessful', 'Room was successfully updated.', 0, '製品が更新されました。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomDeleteSuccessful', 'Room was successfully deleted.', 0, '製品が削除されました。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategory', 'Room Category', 0, 'カテゴリー', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomConfirmDelete', 'Confirm Delete', 0, '削除確認', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCategoryList', 'Category List', 0, 'カテゴリー一覧', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCategoryID', 'ID', 0, 'ID', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCategoryName', 'Category Name', 0, 'カテゴリー名', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCategoryCreate', 'Category Create', 0, 'カテゴリー作成', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCategoryUpdate', 'Category Update', 0, 'カテゴリー更新', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryNameEnglish', 'Category Name (English)', 0, 'カテゴリー名(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryDescriptionEnglish', 'Description (English)', 0, '詳細(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryNameJapanese', 'Category Name (Japanese)', 0, 'カテゴリー名(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryDescriptionJapanese', 'Description (Japanese)', 0, '詳細(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryConfirmDelete', 'Confirm Delete', 0, '削除確認', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemCreatingYourWorkspaceRoomCategory', 'There was a problem creating your category.', 0, 'エラーが発生して、カテゴリーが作成されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemUpdatingYourWorkspaceRoomCategory', 'There was a problem updating your category.', 0, 'エラーが発生して、カテゴリーが更新されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemDeletingYourWorkspaceRoomCategory', 'There was a problem deleting your category.', 0, 'エラーが発生して、カテゴリーが削除されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomCategoryUpdateSuccessful', 'Category was successfully updated.', 0, 'カテゴリーが更新されました。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewsList', 'News List', 0, 'ニュース一覧', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewsID', 'ID', 0, 'ID', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewsTitle', 'Title', 0, '題名', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewsCreate', 'Add News', 0, 'ニュース新規追加', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewsUpdate', 'Update News', 0, 'ニュース更新', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newConfirmDelete', 'Delete News', 0, 'ニュース削除', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsTitleEnglish', 'Title (English)', 0, '題名(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsContentEnglish', 'Content (English)', 0, '内容(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsTitleJapanese', 'Title (Japanese)', 0, '題名(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsContentJapanese', 'Content (Japanese)', 0, '内容(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsTitle', 'Title', 0, '題名', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsContent', 'Content', 0, '内容', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemCreatingYourWorkspaceNews', 'There was a problem adding your news.', 0, 'エラーが発生して、ニュースが追加されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemUpdatingYourWorkspaceNews', 'There was a problem updating your news.', 0, 'エラーが発生して、ニュースが更新されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('thereWasAProblemDeletingYourWorkspaceNews', 'There was a problem deleting your news.', 0, 'エラーが発生して、ニュースが削除されなかったです。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsUpdateSuccessful', 'News was successfully updated.', 0, 'ニュースが更新されました。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsDeleteSuccessful', 'News was successfully deleted.', 0, 'ニュースが削除されました。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceNewRooms', 'New Rooms', 0, 'New Rooms', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRecentNews', 'News', 0, 'News', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoom', 'Room', 0, '製品', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomFeatures', 'Features', 0, '特徴', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomSpecifications', 'Specifications', 0, '仕様', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomImages', 'Images', 0, 'イメージ', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomFiles', 'Files', 0, 'ファイル', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomFeatureNameEnglish', 'Feature (English)', 0, '特徴(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomFeatureNameJapanese', 'Feature (Japanese)', 0, '特徴(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomFeatureManager', 'Feature Manager', 0, '特徴管理', 0, @now);
INSERT INTO perihelion_Lang VALUES ('returnToRoom', 'Return to Room', 0, '製品に戻る', 0, @now);
INSERT INTO perihelion_Lang VALUES ('addNewFeatureHere', 'Add new feature here.', 0, '新規特徴をここに入力して下さい。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomSpecificationManager', 'Specification Manager', 0, '仕様管理', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomSpecificationNameEnglish', 'Specification Name (English)', 0, '仕様名(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomSpecificationDescriptionEnglish', 'Specification Description (English)', 0, '仕様詳細(英語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomSpecificationNameJapanese', 'Specification Name (Japanese)', 0, '仕様名(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('roomSpecificationDescriptionJapanese', 'Specification Description (Japanese)', 0, '仕様詳細(日本語)', 0, @now);
INSERT INTO perihelion_Lang VALUES ('onlyAlphanumericAndHyphenInputAreAllowedInTheUrlField', 'Only alphanumerics and hyphens only allowed in the URL field.', 0, 'URLは英数字とハイフンのみでお願いします。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsUrlAlreadyExists', 'URL already in use.', 0, '入力されたURLは既に使われています。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsUrlAlreadyUsedByAnotherNewsItem', 'URL already in use by another news item.', 0, '入力されたURLは別の記事で使われています。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsUrlMustBeSet', 'The URL must be set.', 0, 'URLの入力は必須です。', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsURL', 'URL', 0, 'URL', 0, @now);
INSERT INTO perihelion_Lang VALUES ('alphanumericHyphenOnly', 'Alphanumerics and Hyphens only', 0, '英数字・ハイフンのみ', 0, @now);
INSERT INTO perihelion_Lang VALUES ('newsDate', 'Date', 0, '日付', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomDownloads', 'Downloads', 0, 'ダウンロード', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceFeaturedRooms', 'Featured Rooms', 0, 'Featured Rooms', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomCatalog', 'Room Catalog', 0, '製品カタログ', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRooms', 'Rooms', 0, '製品', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomPublished', 'Published', 0, '公開', 0, @now);
INSERT INTO perihelion_Lang VALUES ('workspaceRoomFeatured', 'Featured', 0, '特徴', 0, @now);

-- INSERT INTO perihelion_Lang VALUES ('xxxxxxx', 'xxxxxxx', 0, 'xxxxxxx', 0, @now);

