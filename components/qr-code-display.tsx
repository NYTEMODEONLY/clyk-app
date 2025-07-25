'use client'

import { useState } from 'react'
import QRCode from 'react-qr-code'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Download, QrCode } from 'lucide-react'
import { toast } from 'sonner'

interface QRCodeDisplayProps {
  value: string
  size?: number
}

export function QRCodeDisplay({ value, size = 200 }: QRCodeDisplayProps) {
  const [isGenerating, setIsGenerating] = useState(false)

  const downloadQRCode = async () => {
    setIsGenerating(true)
    try {
      const svg = document.getElementById('qr-code-svg')
      if (!svg) throw new Error('QR code not found')

      const svgData = new XMLSerializer().serializeToString(svg)
      const canvas = document.createElement('canvas')
      const ctx = canvas.getContext('2d')
      const img = new Image()

      canvas.width = size
      canvas.height = size

      img.onload = () => {
        if (!ctx) return
        ctx.fillStyle = 'white'
        ctx.fillRect(0, 0, size, size)
        ctx.drawImage(img, 0, 0, size, size)
        
        canvas.toBlob((blob) => {
          if (!blob) return
          const url = URL.createObjectURL(blob)
          const a = document.createElement('a')
          a.href = url
          a.download = `qr-code-${Date.now()}.png`
          document.body.appendChild(a)
          a.click()
          document.body.removeChild(a)
          URL.revokeObjectURL(url)
          toast.success('📱 QR code downloaded! Share it far and wide!')
        })
      }

      img.src = 'data:image/svg+xml;base64,' + btoa(svgData)
    } catch (error) {
      console.error('Error downloading QR code:', error)
      toast.error('Failed to download QR code')
    } finally {
      setIsGenerating(false)
    }
  }

  return (
    <Card className="w-full max-w-xs">
      <CardHeader className="pb-3">
        <CardTitle className="flex items-center">
          <QrCode className="mr-2 h-4 w-4" />
          QR Code
        </CardTitle>
      </CardHeader>
      <CardContent className="flex flex-col items-center space-y-4">
        <div className="p-3 bg-white rounded-lg border">
          <QRCode
            id="qr-code-svg"
            value={value}
            size={size}
            bgColor="#ffffff"
            fgColor="#000000"
            level="M"
          />
        </div>
        
        <div className="text-center space-y-3">
          <p className="text-sm text-muted-foreground">
            Scan to visit your short link
          </p>
          
          <Button
            onClick={downloadQRCode}
            variant="outline"
            size="sm"
            disabled={isGenerating}
          >
            <Download className="mr-1 h-3 w-3" />
            {isGenerating ? 'Generating...' : 'Download PNG'}
          </Button>
        </div>
      </CardContent>
    </Card>
  )
}