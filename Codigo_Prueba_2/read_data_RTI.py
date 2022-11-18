import wave
import numpy as np
from scipy.io.wavfile import read
from scipy.fftpack import fft, ifft
import matplotlib.pyplot as plt

[rate, data] = read('running_outside_20ms.wav', 'r')

c = 299792458.0

Tp = 20 * 1E-3
N = int(Tp * rate)
fi = 2260 * 1E6
ff = 2590 * 1E6
BW = ff-fi
f = np.linspace(fi, ff, N/2)

rr = c/(2*BW)
max_range = rr*(N/2)

data = (-1.0 * data) / 32768
trig = data[:,0]
s = data[:,1]

count = 0
thresh = 0
low_value_indexes = trig < thresh
high_value_indexes = trig > thresh

start = np.zeros([len(trig)], dtype = int)
start[low_value_indexes] = 0
start[high_value_indexes] = 1

sif = []
time = []

for x in range(100, len(start) - N):
    if ((start[x] == 1) and (np.mean(start[x-11:x-1]) == 0)):
        count = count + 1
        sif.append(s[x:x + N -1])
        time.append((x * 1.0) / rate)

sif = np.array(sif)
time = np.array(time)

sif = np.transpose(np.transpose(sif) - (np.mean(sif, axis = 1)))
zpad = (8 * N) / 2

sif2 = sif[2:sif.shape[0],:] - sif[1:sif.shape[0] - 1,:]

v = 20 * np.log10(np.absolute(ifft(sif2, zpad)))

S = (v[:,1:v.shape[1]/2])

fig = plt.figure(1)
im = plt.imshow(S - np.amax(v), aspect = 'auto', cmap = 'jet')
cbar = plt.colorbar(im, orientation = 'vertical')
plt.show()
