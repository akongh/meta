# Meta installation

**Privacy settings**

On hosting `_meta_privacy` folder must be placed on same level as Meta (`/meta/../_meta_privacy/`).
For example of filling see `_meta_extra/_meta_privacy`.

**Fix before sending to prodaction**
```
/ru_en_selection/management/.htaccess
/.htaccess
/analytics_code.php
/analytics_info.php
/robots.txt
```

**Not send to prodaction**
```
readme.md
/_meta_extra/
/.gitignore
```