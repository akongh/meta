# Meta installation

**Fix on production**

On hosting `_meta_privacy` folder must be placed on same level as Meta (`/meta/../_meta_privacy/`).  
For example of filling see `_meta_extra/_meta_privacy`.

**If needed**
```
/meta/../_meta_privacy/
/_meta_privacy/management/.htaccess
/_meta_privacy/.htaccess
```

**Not send to production**

```
/_meta_extra/
/.gitignore
readme.md
```