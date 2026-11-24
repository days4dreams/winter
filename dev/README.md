# Developer files (never uploaded to the website)

- `deploy.sh`: uploads changed files to Krystal; run by GitHub Actions.
- `check.sh`: checks every page loads with no PHP errors; run before every upload
  and on every pull request. You can run it yourself: `bash dev/check.sh`
- `urls.txt`: the page addresses `check.sh` tests. Add new pages here.
- `make-edges.py`: makes the torn-paper edge shapes in `images/edges/`.
- `style-sample/`: the one-page style sample agreed on 20 November 2026.
