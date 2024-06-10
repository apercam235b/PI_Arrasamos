import os
os.environ['OPENCV_LOG_LEVEL'] = 'SILENT'

import cv2
import numpy as np
from datetime import datetime
import argparse

def capture_rectangle(frame, approx):
    x, y, w, h = cv2.boundingRect(approx)
    rect_img = frame[y:y+h, x:x+w]
    return rect_img

def captura_pizarra(ruta):
    cap = cv2.VideoCapture(0)
    if not cap.isOpened():
        print("Error: No se puede acceder a la cámara")
        return

    while True:
        ret, frame = cap.read()
        if not ret:
            print("Error: No se puede recibir el cuadro (stream end?). Saliendo ...")
            break

        hsv = cv2.cvtColor(frame, cv2.COLOR_BGR2HSV)
        lower_green = np.array([35, 100, 100])
        upper_green = np.array([85, 255, 255])
        mask = cv2.inRange(hsv, lower_green, upper_green)
        mask = cv2.erode(mask, None, iterations=2)
        mask = cv2.dilate(mask, None, iterations=2)
        contours, _ = cv2.findContours(mask, cv2.RETR_TREE, cv2.CHAIN_APPROX_SIMPLE)
        
        for contour in contours:
            approx = cv2.approxPolyDP(contour, 0.02 * cv2.arcLength(contour, True), True)
            area = cv2.contourArea(approx)
            if len(approx) == 4:  # Aseguramos que sea un rectángulo con área suficiente
                rect_img = capture_rectangle(frame, approx)
                now = datetime.now()
                fecha_hora = now.strftime("%Y-%m-%d_%H-%M-%S")
                filename = os.path.join(ruta, f'captura_{fecha_hora}.png')
                cv2.imwrite(filename, rect_img)
                print(f'Imagen guardada: {filename}')
                cap.release()
                return

    cap.release()

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Captura una imagen de la cámara y la guarda en la ruta especificada.")
    parser.add_argument("ruta", type=str, help="Ruta donde se guardará la imagen.")
    args = parser.parse_args()
    captura_pizarra(args.ruta)
