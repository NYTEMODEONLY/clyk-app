'use client'

import { useEffect, useState } from 'react'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Button } from '@/components/ui/button'
import { formatDate } from '@/lib/utils'
import { Eye, ExternalLink, Calendar, Globe, Monitor, MousePointer } from 'lucide-react'
import Link from 'next/link'
import { useAuth } from '@/components/auth-provider'
import { getLinks, getLinkAnalytics, Link as LinkType, Click } from '@/lib/local-storage'

interface LinkWithCount extends LinkType {
  clickCount: number
}

interface AnalyticsData {
  totalClicks: number
  referers: Array<{ name: string; count: number }>
  countries: Array<{ name: string; count: number }>
  devices: Array<{ name: string; count: number }>
  browsers: Array<{ name: string; count: number }>
}


export function AnalyticsDashboard() {
  const { user } = useAuth()
  const [links, setLinks] = useState<LinkWithCount[]>([])
  const [selectedLink, setSelectedLink] = useState<LinkType | null>(null)
  const [analytics, setAnalytics] = useState<AnalyticsData | null>(null)
  const [recentClicks, setRecentClicks] = useState<Click[]>([])
  const [isLoading, setIsLoading] = useState(true)
  const [isLoadingAnalytics, setIsLoadingAnalytics] = useState(false)

  useEffect(() => {
    fetchLinks()
  }, [])

  const fetchLinks = () => {
    try {
      const allLinks = getLinks()
      const linksWithCount: LinkWithCount[] = allLinks.map(link => ({
        ...link,
        clickCount: link.clicks.length
      }))
      setLinks(linksWithCount)
    } catch (error) {
      console.error('Error fetching links:', error)
    } finally {
      setIsLoading(false)
    }
  }

  const fetchAnalytics = (linkId: string) => {
    setIsLoadingAnalytics(true)
    try {
      const data = getLinkAnalytics(linkId)
      if (data) {
        setAnalytics(data.analytics)
        setRecentClicks(data.recentClicks)
      }
    } catch (error) {
      console.error('Error fetching analytics:', error)
    } finally {
      setIsLoadingAnalytics(false)
    }
  }

  const handleLinkSelect = (link: LinkType) => {
    setSelectedLink(link)
    fetchAnalytics(link.id)
  }

  if (!user) {
    return (
      <div className="text-center py-8">
        <h1 className="text-2xl font-bold mb-4">Analytics Dashboard</h1>
        <p className="text-muted-foreground mb-4">
          Please sign in to view your link analytics
        </p>
      </div>
    )
  }

  if (isLoading) {
    return (
      <div className="space-y-4">
        <div className="h-8 bg-gray-200 rounded animate-pulse" />
        <div className="h-64 bg-gray-200 rounded animate-pulse" />
      </div>
    )
  }

  return (
    <div className="h-full flex flex-col space-y-6 overflow-hidden">
      <div className="flex-shrink-0 space-y-2">
        <h1 className="text-2xl sm:text-3xl font-bold">Analytics Dashboard</h1>
        <p className="text-muted-foreground">
          Track your shortened URLs and analyze their performance
        </p>
      </div>

      <Card className="flex-shrink-0">
        <CardHeader className="pb-4">
          <CardTitle className="text-lg">Your Links</CardTitle>
        </CardHeader>
        <CardContent>
          {links.length === 0 ? (
            <div className="text-center py-8">
              <p className="text-muted-foreground mb-4">
                No links created yet. Start by shortening your first URL!
              </p>
              <Link href="/">
                <Button size="sm">Create Your First Link</Button>
              </Link>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead className="min-w-[120px]">Short Link</TableHead>
                    <TableHead className="min-w-[200px]">Original URL</TableHead>
                    <TableHead className="min-w-[80px]">Clicks</TableHead>
                    <TableHead className="min-w-[120px] hidden sm:table-cell">Created</TableHead>
                    <TableHead className="min-w-[100px]">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {links.slice(0, 5).map((link) => (
                    <TableRow key={link.id}>
                      <TableCell className="font-mono py-3">
                        <a
                          href={link.shortUrl}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="hover:underline flex items-center"
                        >
                          /{link.shortCode}
                          <ExternalLink className="ml-1 h-3 w-3" />
                        </a>
                      </TableCell>
                      <TableCell className="py-3">
                        <div className="max-w-[150px] sm:max-w-xs truncate" title={link.originalUrl}>
                          {link.title || link.originalUrl}
                        </div>
                      </TableCell>
                      <TableCell className="py-3">
                        <div className="flex items-center">
                          <MousePointer className="mr-1 h-3 w-3" />
                          {link.clickCount}
                        </div>
                      </TableCell>
                      <TableCell className="hidden sm:table-cell py-3">
                        <div className="flex items-center text-sm">
                          <Calendar className="mr-1 h-3 w-3" />
                          {formatDate(new Date(link.createdAt))}
                        </div>
                      </TableCell>
                      <TableCell className="py-3">
                        <Button
                          onClick={() => handleLinkSelect(link)}
                          variant="outline"
                          size="sm"
                        >
                          <Eye className="mr-1 h-3 w-3" />
                          <span className="hidden sm:inline">View Analytics</span>
                          <span className="sm:hidden">View</span>
                        </Button>
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          )}
        </CardContent>
      </Card>

      {selectedLink && (
        <div className="flex-1 overflow-y-auto space-y-6 min-h-0">
          <div className="flex-shrink-0 space-y-1">
            <h2 className="text-lg font-semibold">
              Analytics for /{selectedLink.shortCode}
            </h2>
            <p className="text-muted-foreground text-sm break-all">
              {selectedLink.originalUrl}
            </p>
          </div>

          {isLoadingAnalytics ? (
            <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
              {[...Array(4)].map((_, i) => (
                <div key={i} className="h-24 bg-gray-200 rounded animate-pulse" />
              ))}
            </div>
          ) : analytics ? (
            <div className="space-y-6">
              <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <Card>
                  <CardHeader className="pb-2">
                    <CardTitle className="text-sm font-medium">Total Clicks</CardTitle>
                  </CardHeader>
                  <CardContent className="pt-2">
                    <div className="text-2xl font-bold">{analytics.totalClicks}</div>
                  </CardContent>
                </Card>

                <Card>
                  <CardHeader className="pb-2">
                    <CardTitle className="text-sm font-medium">Top Referrer</CardTitle>
                  </CardHeader>
                  <CardContent className="pt-2">
                    <div className="text-2xl font-bold truncate">
                      {analytics.referers[0]?.name || 'None'}
                    </div>
                    <p className="text-xs text-muted-foreground">
                      {analytics.referers[0]?.count || 0} clicks
                    </p>
                  </CardContent>
                </Card>

                <Card>
                  <CardHeader className="pb-2">
                    <CardTitle className="text-sm font-medium">Top Country</CardTitle>
                  </CardHeader>
                  <CardContent className="pt-2">
                    <div className="text-2xl font-bold truncate">
                      {analytics.countries[0]?.name || 'Unknown'}
                    </div>
                    <p className="text-xs text-muted-foreground">
                      {analytics.countries[0]?.count || 0} clicks
                    </p>
                  </CardContent>
                </Card>

                <Card>
                  <CardHeader className="pb-2">
                    <CardTitle className="text-sm font-medium">Top Device</CardTitle>
                  </CardHeader>
                  <CardContent className="pt-2">
                    <div className="text-2xl font-bold truncate">
                      {analytics.devices[0]?.name || 'Unknown'}
                    </div>
                    <p className="text-xs text-muted-foreground">
                      {analytics.devices[0]?.count || 0} clicks
                    </p>
                  </CardContent>
                </Card>
              </div>

              <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <Card>
                  <CardHeader className="pb-3">
                    <CardTitle className="flex items-center">
                      <Globe className="mr-2 h-4 w-4" />
                      Countries
                    </CardTitle>
                  </CardHeader>
                  <CardContent className="pt-3">
                    {analytics.countries.length > 0 ? (
                      <div className="space-y-2">
                        {analytics.countries.slice(0, 3).map((country) => (
                          <div key={country.name} className="flex justify-between">
                            <span className="truncate">{country.name}</span>
                            <span className="font-semibold">{country.count}</span>
                          </div>
                        ))}
                      </div>
                    ) : (
                      <p className="text-muted-foreground">No data available</p>
                    )}
                  </CardContent>
                </Card>

                <Card>
                  <CardHeader className="pb-3">
                    <CardTitle className="flex items-center">
                      <Monitor className="mr-2 h-4 w-4" />
                      Devices
                    </CardTitle>
                  </CardHeader>
                  <CardContent className="pt-3">
                    {analytics.devices.length > 0 ? (
                      <div className="space-y-2">
                        {analytics.devices.slice(0, 3).map((device) => (
                          <div key={device.name} className="flex justify-between">
                            <span className="capitalize truncate">{device.name}</span>
                            <span className="font-semibold">{device.count}</span>
                          </div>
                        ))}
                      </div>
                    ) : (
                      <p className="text-muted-foreground">No data available</p>
                    )}
                  </CardContent>
                </Card>
              </div>

              <Card>
                <CardHeader className="pb-3">
                  <CardTitle>Recent Clicks</CardTitle>
                </CardHeader>
                <CardContent className="pt-3">
                  {recentClicks.length > 0 ? (
                    <div className="overflow-x-auto">
                      <Table>
                        <TableHeader>
                          <TableRow>
                            <TableHead className="min-w-[120px]">Time</TableHead>
                            <TableHead className="min-w-[120px]">Location</TableHead>
                            <TableHead className="min-w-[80px] hidden sm:table-cell">Device</TableHead>
                            <TableHead className="min-w-[80px] hidden md:table-cell">Browser</TableHead>
                          </TableRow>
                        </TableHeader>
                        <TableBody>
                          {recentClicks.slice(0, 5).map((click) => (
                            <TableRow key={click.id}>
                              <TableCell className="py-2">
                                {formatDate(new Date(click.timestamp))}
                              </TableCell>
                              <TableCell className="py-2">
                                {click.city && click.country
                                  ? `${click.city}, ${click.country}`
                                  : click.country || 'Unknown'}
                              </TableCell>
                              <TableCell className="capitalize hidden sm:table-cell py-2">
                                {click.device || 'Unknown'}
                              </TableCell>
                              <TableCell className="hidden md:table-cell py-2">
                                {click.browser || 'Unknown'}
                              </TableCell>
                            </TableRow>
                          ))}
                        </TableBody>
                      </Table>
                    </div>
                  ) : (
                    <p className="text-muted-foreground">No clicks yet</p>
                  )}
                </CardContent>
              </Card>
            </div>
          ) : null}
        </div>
      )}
    </div>
  )
}