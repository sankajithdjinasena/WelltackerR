from flask import Flask, request, render_template, jsonify
import pickle
import numpy as np
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

# Load model
with open('../model/diabetic_model.pkl', 'rb') as file:
    model = pickle.load(file)

with open('../model/diabetic_scaler.pkl', 'rb') as file:
    loaded_scaler = pickle.load(file)

@app.route('/predict', methods=['POST'])
def predict_prediction():
    try:
        data = request.form

        # Ensure all required keys are present and are float-convertible
        required_fields = ['Pregnancies', 'Glucose', 'BloodPressure', 'SkinThickness', 'Insulin', 'BMI', 'DPF', 'Age']
        processed_data = [float(data[field]) for field in required_fields]

        # Scaling and Prediction
        processed_data_scaled = loaded_scaler.transform([processed_data])[0]
        prediction = model.predict([processed_data_scaled])

        # Convert prediction result to a human-readable string
        # Assuming 0 is 'No Diabetes' and 1 is 'Diabetes'
        result_text = "Diabetic" if prediction[0] == 1 else "Non-Diabetic"

        # Return a JSON response with the prediction result
        return jsonify({'prediction_result': result_text})

    except Exception as e:
        print("Error during prediction:", e)
        # Return a JSON error response
        return jsonify({'error': str(e)}), 400 # Use status code 400 for bad request


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=10000, debug=True)
