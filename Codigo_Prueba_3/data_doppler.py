import numpy as np
from scipy.io.wavfile import read
from scipy.fftpack import fft, ifft
from scipy.signal import decimate
import matplotlib.pyplot as plt
import h5py

[rate, data] = read('output.wav', 'r')

c = 299792458.0
decimation_factor = 80
Tp = 10 * 23 * 1E-3
N = Tp * rate / decimation_factor
fc = 2590 * 1E6
data = (-1.0 * data) / 32768
data = data[:,1]
data = data.reshape(-1, decimation_factor).mean(axis = 1)
data = data[0:(int(data.shape[0]/int(N))) * int(N)]
data_matrix = np.reshape(data, (int(data.shape[0]/int(N)), int(N)))
mean = data_matrix.mean(axis = 0)
data_matrix = data_matrix - mean

zpad = (8 * N) / 2
v = 20 * np.log10(np.absolute(ifft(data_matrix,n = int(zpad))))

v = v[:,0:v.shape[1]/2]

delta_f = np.linspace(0, rate / 2 / decimation_factor, v.shape[1])
wavelength = c / fc
velocity = delta_f * wavelength / 2

time = np.linspace(1,Tp * v.shape[0],v.shape[0])

vmin = velocity[0]
vmax = velocity[len(velocity) - 1]
ti = time[0]
tf = time[len(time) - 1]

'''
fig = plt.figure(1)
plt.title('Doppler velocity', fontsize = 14)
im = plt.imshow((v), cmap = 'jet', aspect = 'auto', extent = [vmin, vmax, ti - 1, tf] )
cbar = plt.colorbar(im, orientation = 'vertical')
plt.xlabel('velocity (m/s)', fontsize = 10)
plt.ylabel('time(s)', fontsize = 10)
plt.show()
'''
