# PHPGithubAPI
PHP library for github api(https://developer.github.com/, https://api.github.com/)

Available functions :

String | $githubAPI->getUserAgent()
String | $githubAPI->getToken() //Private function

# -RateLimit // https://api.github.com/rate_limit
Boolean | $githubAPI->isLimit($type) // core/search/graphql/integration_manifest
String | $githubAPI->getLimit_Remaining($type) // core/search/graphql/integration_manifest
Object/Variable | $githubAPI->getRateLimit("core/search/graphql/integration_manifest/limit/remaining/reset) // Exemple : $githubAPI->getRateLimit('core/limit');

# -Releases // https://api.github.com/repos/:owner/:repo/releases
Object | $githubAPI->getListReleases($owner, $repo) // https://api.github.com/repos/:owner/:repo/releases
Object | $githubAPI->getReleaseByID($owner, $repo, $release_id) // https://api.github.com/repos/:owner/:repo/releases/:release_id
Object | $githubAPI->getReleaseByTag($owner, $repo, $release_tag) // https://api.github.com/repos/:owner/:repo/releases/tags/:release_tag
Object | $githubAPI->getListAssets($owner, $repo, $release_id) // https://api.github.com/repos/:owner/:repo/releases/:release_id/assets
Object | $githubAPI->getAsset($owner, $repo, $asset_id) // https://api.github.com/repos/:owner/:repo/releases/assets/:asset_id
Object | $githubAPI->getLatestRelease($owner, $repo) // https://api.github.com/repos/:owner/:repo/releases/latest

# -Downloads // https://api.github.com/repos/:owner/:repo/downloads
Object | $githubAPI->getListDownloads($owner, $repo) // https://api.github.com/repos/:owner/:repo/downloads
Object | $githubAPI->getDownload($owner, $repo, $download_id) // https://api.github.com/repos/:owner/:repo/downloads/:download_id
Nothing | $githubAPI->deleteDownload($owner, $repo, $download_id) // https://api.github.com/repos/:owner/:repo/downloads/:download_id

# -Comments // https://api.github.com/repos/:owner/:repo/comments
Object | $githubAPI->getListComments($owner, $repo) // https://api.github.com/repos/:owner/:repo/comments
Object | $githubAPI->getListCommentsForSingleCommit($owner, $repo, $commit_sha) // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
Object | $githubAPI->CreateCommitComment($owner, $repo, $commit_sha, $array=array("body" => "", "path" => "", "postion" => 0, "line" => null)) // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
Object | $githubAPI->GetCommitComment($owner, $repo, $comment_id) // https://api.github.com/repos/:owner/:repo/comments/:comment_id
Object | $githubAPI->UpdateCommitComment($owner, $repo, $comment_id, $array=array("body" => "")) // https://api.github.com/repos/:owner/:repo/commits/:commit_sha/comments
Nothing | $githubAPI->DeleteCommitComment($owner, $repo, $comment_id) // https://api.github.com/repos/:owner/:repo/comments/:comment_id

# -Collaborators // https://api.github.com/repos/:owner/:repo/collaborators
Object | $githubAPI->GetListCollaborators($owner, $repo) // https://api.github.com/repos/:owner/:repo/collaborators
Object | $githubAPI->CheckUserIsCollaborator($owner, $repo, $username) // https://api.github.com/repos/:owner/:repo/collaborators/:username
Object | $githubAPI->GetUserPermissionLevel($owner, $repo, $username) // https://api.github.com/repos/:owner/:repo/collaborators/:username/permission
Nothing | $githubAPI->DeleteUserCollaborator($owner, $repo, $username) // https://api.github.com/repos/:owner/:repo/collaborators/:username
