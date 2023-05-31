# Meta installation

**Fix on production**

On hosting `_meta_privacy` folder must be placed on same level as Meta (`/meta/../_meta_privacy/`).  
For example of filling see `_meta_extra/_meta_privacy`.

```
/meta/../_meta_privacy/
/.htaccess
/robots.txt
```

**Not send to production**

```
/_meta_extra/
/.htaccess
/robots.txt
/readme.md
/.gitignore
```