@echo off
set FLASK_APP=lung_app.py
set FLASK_ENV=development
python -m flask run --port=10001
pause