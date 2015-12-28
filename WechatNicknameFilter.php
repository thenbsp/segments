<?

// 只负责过滤表情，不包括 HTML 符号
public function setNickname($nickname)
{
    // Match Emoticons
    $nickname = preg_replace('/[\x{1F600}-\x{1F64F}]/u', '', $nickname);

    // Match Miscellaneous Symbols and Pictographs
    $nickname = preg_replace('/[\x{1F300}-\x{1F5FF}]/u', '', $nickname);

    // Match Transport And Map Symbols
    $nickname = preg_replace('/[\x{1F680}-\x{1F6FF}]/u', '', $nickname);

    // Match Miscellaneous Symbols
    $nickname = preg_replace('/[\x{2600}-\x{26FF}]/u', '', $nickname);

    // Match Dingbats
    $nickname = preg_replace('/[\x{2700}-\x{27BF}]/u', '', $nickname);

    return trim($nickname);
}
