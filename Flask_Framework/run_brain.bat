@echo off
set FLASK_APP=brain_app.py
set FLASK_ENV=development
python -m flask run --port=5001
pause