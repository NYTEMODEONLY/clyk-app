'use client'

import { useState } from 'react'
import { nanoid } from 'nanoid'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Card, CardContent } from '@/components/ui/card'
import { QRCodeDisplay } from '@/components/qr-code-display'
import { toast } from 'sonner'
import { Copy, Link, Loader2 } from 'lucide-react'
import { isValidUrl, getBaseUrl } from '@/lib/utils'
import { saveLink, isShortCodeTaken, Link as LinkType } from '@/lib/local-storage'

interface ShortenedLink {
  id: string
  originalUrl: string
  shortCode: string
  shortUrl: string
  title: string
  createdAt: string
}

export function UrlShortener() {
  const [url, setUrl] = useState('')
  const [customAlias, setCustomAlias] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const [shortenedLink, setShortenedLink] = useState<ShortenedLink | null>(null)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    
    if (!url.trim()) {
      toast.error('Please enter a URL')
      return
    }

    if (!isValidUrl(url)) {
      toast.error('Please enter a valid URL')
      return
    }

    setIsLoading(true)

    try {
      let shortCode = customAlias.trim()
      
      if (shortCode) {
        if (isShortCodeTaken(shortCode)) {
          throw new Error('Custom alias already taken')
        }
      } else {
        // Generate unique short code
        do {
          shortCode = nanoid(8)
        } while (isShortCodeTaken(shortCode))
      }

      // Try to fetch page title
      let title = ''
      try {
        const response = await fetch(`https://api.allorigins.win/get?url=${encodeURIComponent(url)}`)
        if (response.ok) {
          const data = await response.json()
          const html = data.contents
          const titleMatch = html.match(/<title>(.*?)<\/title>/i)
          title = titleMatch ? titleMatch[1].trim() : ''
        }
      } catch {
        // Continue without title if fetch fails
      }

      const link: LinkType = {
        id: `link_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`,
        originalUrl: url,
        shortCode,
        shortUrl: `${getBaseUrl()}/l/${shortCode}`,
        title: title || new URL(url).hostname,
        customAlias: customAlias.trim() || undefined,
        createdAt: new Date().toISOString(),
        clicks: []
      }

      saveLink(link)

      const result: ShortenedLink = {
        id: link.id,
        originalUrl: link.originalUrl,
        shortCode: link.shortCode,
        shortUrl: link.shortUrl,
        title: link.title,
        createdAt: link.createdAt,
      }

      setShortenedLink(result)
      setUrl('')
      setCustomAlias('')
      toast.success('🎉 URL shortened successfully! Time to share the magic!')
    } catch (error) {
      console.error('Error shortening URL:', error)
      toast.error(error instanceof Error ? error.message : 'Failed to shorten URL')
    } finally {
      setIsLoading(false)
    }
  }

  const copyToClipboard = async (text: string) => {
    try {
      await navigator.clipboard.writeText(text)
      toast.success('✨ Copied to clipboard! Go spread the link love!')
    } catch (error) {
      toast.error('Failed to copy to clipboard')
    }
  }

  const resetForm = () => {
    setShortenedLink(null)
    setUrl('')
    setCustomAlias('')
  }

  return (
    <div className="w-full max-w-2xl mx-auto">
      <Card className="shadow-lg">
        <CardContent className="p-6 sm:p-8">
          {!shortenedLink ? (
            // Form View
            <div className="space-y-6">
              <div className="space-y-5">
                <div className="space-y-3">
                  <label htmlFor="url" className="text-sm font-medium">
                    Enter your long URL
                  </label>
                  <Input
                    id="url"
                    type="url"
                    placeholder="https://example.com/very/long/url"
                    value={url}
                    onChange={(e) => setUrl(e.target.value)}
                    disabled={isLoading}
                    className="text-base h-12"
                  />
                </div>
                
                <div className="space-y-3">
                  <label htmlFor="alias" className="text-sm font-medium">
                    Custom alias (optional)
                  </label>
                  <Input
                    id="alias"
                    type="text"
                    placeholder="my-custom-link"
                    value={customAlias}
                    onChange={(e) => setCustomAlias(e.target.value)}
                    disabled={isLoading}
                    className="text-base h-12"
                  />
                  <p className="text-xs text-muted-foreground">
                    Leave empty for auto-generated short code
                  </p>
                </div>
              </div>

              <Button 
                type="submit" 
                onClick={handleSubmit}
                disabled={isLoading || !url.trim()}
                className="w-full h-12 text-base"
                size="lg"
              >
                {isLoading ? (
                  <>
                    <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                    Shortening...
                  </>
                ) : (
                  <>
                    <Link className="mr-2 h-4 w-4" />
                    Shorten URL
                  </>
                )}
              </Button>
            </div>
          ) : (
            // Results View
            <div className="space-y-6">
              <div className="text-center space-y-4">
                <h3 className="text-lg font-semibold">
                  🎉 Your shortened URL is ready!
                </h3>
                
                <div className="space-y-4">
                  <div className="flex items-center space-x-2">
                    <Input
                      value={shortenedLink.shortUrl}
                      readOnly
                      className="flex-1 font-mono text-base h-12"
                    />
                    <Button
                      onClick={() => copyToClipboard(shortenedLink.shortUrl)}
                      variant="outline"
                      size="icon"
                      className="h-12 w-12 hover:scale-105 transition-transform duration-200"
                    >
                      <Copy className="h-4 w-4" />
                    </Button>
                  </div>
                  
                  {shortenedLink.title && (
                    <p className="text-sm text-muted-foreground">
                      {shortenedLink.title}
                    </p>
                  )}
                  
                  <p className="text-xs text-muted-foreground break-all">
                    Original: {shortenedLink.originalUrl.length > 60 
                      ? shortenedLink.originalUrl.slice(0, 60) + '...' 
                      : shortenedLink.originalUrl}
                  </p>
                </div>
              </div>

              <div className="flex justify-center py-4">
                <QRCodeDisplay 
                  value={shortenedLink.shortUrl}
                  size={160}
                />
              </div>

              <div className="flex justify-center pt-2">
                <Button
                  onClick={resetForm}
                  variant="outline"
                  className="hover:scale-105 transition-transform duration-200"
                >
                  <Link className="mr-2 h-4 w-4" />
                  Create Another Link
                </Button>
              </div>
            </div>
          )}
        </CardContent>
      </Card>
    </div>
  )
}